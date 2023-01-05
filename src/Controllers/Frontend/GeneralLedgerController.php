<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use memfisfa\Finac\Model\QueryFunction as QF;
use memfisfa\Finac\Model\Coa;
use Carbon\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\GLExport;
use Maatwebsite\Excel\Facades\Excel;
use memfisfa\Finac\Model\TrxJournal;
use memfisfa\Finac\Model\TrxJournalA;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        $data = [
            'all_coa' => json_encode(Coa::orderBy('code')->where('description', 'Detail')->get()->toArray()),
        ];

        return view('generalledgerview::index', $data);
    }

    public function getEndingBalance($balance, $coa_type, $item)
    {
        // 1. Tipe coa Aktiva = balance/saldo awal + saldo debet - saldo kredit
        // 2. Tipe coa Pasiva = balance/saldo awal - saldo debet + saldo kredit.
        // 3. Tipe coa Ekuitas = Balance/Saldo awal + saldo kredit - saldo debet
        // 4. Tipe coa Pendapatan = Balance/Saldo awal + saldo kredit - saldo debet.
        // 5. Tipe coa beban/biaya = Balance/Saldo awal + saldo debet - saldo 

        if ($coa_type == 'activa') {
            $result = $balance + $item->Debit - $item->Credit;
        }

        if ($coa_type == 'pasiva') {
            $result = $balance - $item->Debit + $item->Credit;
        }

        if ($coa_type == 'ekuitas') {
            $result = $balance + $item->Credit - $item->Debit;
        }

        if ($coa_type == 'pendapatan') {
            $result = $balance + $item->Credit - $item->Debit;
        }

        if ($coa_type == 'biaya') {
            $result = $balance + $item->Debit - $item->Credit;
        }

        return $result;
    }

    public function show(Request $request)
    {
        ini_set('max_execution_time', '-1');
        ini_set('memory_limit', '-1');

        $code = explode(',', $request->data);
        $coa = Coa::whereIn('code', $code)->get();

        if (count($coa) < 1) {
            return redirect()->back()->with(['errors' => 'Coa not found']);
        }

        $date = $this->convertDate($request->date);

        $beginDate = $date[0];
        $endingDate = $date[1];

        for ($i=0; $i < count($coa); $i++) {

            $get_data = $this->getData(
                    $beginDate, $endingDate, $coa[$i]->code
                );

            $data_coa[] = $get_data;
        }

        $data_coa = array_values(array_filter($data_coa));

        foreach ($data_coa as $data_coa_row) {
            foreach ($data_coa_row['data'] as $data_row) {
                $data_row->description_formated = $data_row->Description_2 ?? $data_row->Description;
            }
        }

        $data = [
            'data' => $data_coa,
            'beginDate' => $beginDate,
            'endingDate' => $endingDate,
            'coa' => $coa,
            'carbon' => Carbon::class,
            'controller' => new Controller()
        ];

        return view('generalledgerview::show', $data);
    }

    private function queryGetData($coa, $journal_approve = true)
    {
        $query =  "
            SELECT
            DATE_ADD(@startDate, INTERVAL -1 DAY) as TransactionDate,
            ' ' as CreatedAt,
            'Saldo Awal' as VoucherNo,
            ' ' as RefNo,
            ' ' as journal_uuid,
            m_journal.code as AccountCode,
            m_journal.Name as Name,
            IFNULL(
            (select sum(debit-Credit) from trxjournala
            left join trxjournals on trxjournals.Voucher_No=trxjournala.Voucher_No
            where
            cast(IFNULL(trxjournals.ref_date, trxjournals.transaction_date) as date) < @startDate
            and
            trxjournala.account_code = m_journal.id
            )
            ,0)
            AS SaldoAwal,
            0 AS Debit,
            0 AS Credit,
            'Saldo Awal' AS Description,
            'Saldo Awal' AS Description_2
            FROM m_journal
            WHERE
            m_journal.description = 'Detail'
            and
            m_journal.code in (".$coa.")
            UNION ALL
            (SELECT
            IFNULL(trxjournals.ref_date, trxjournals.transaction_date) as TransactionDate,
            trxjournals.created_at as CreatedAt,
            trxjournals.voucher_no as VoucherNo,
            trxjournals.ref_no as RefNo,
            trxjournals.uuid as journal_uuid,
            m_journal.code as AccountCode,
            m_journal.Name as Name,
            0 AS SaldoAwal ,
            trxjournala.Debit AS Debit,
            trxjournala.Credit AS Credit,
            trxjournala.description AS Description,
            trxjournala.description_2 AS Description_2
            from
            trxjournals
            left join trxjournala
            on trxjournals.voucher_no = trxjournala.voucher_no
            left join m_journal
            on trxjournala.account_code = m_journal.id
            where cast(IFNULL(trxjournals.ref_date, trxjournals.transaction_date) as date) between @startDate and @endDate";

        if ($journal_approve) {
            $query .= "
                and trxjournals.approve = true
            ";
        }

        $query .= "
            and m_journal.code in (".$coa."))
            order by AccountCode,TransactionDate, CreatedAt asc
        ";

        return $query;
    }

    public function getData($beginDate, $endingDate, $coa)
    {

        $queryStatement ='
            SET @startDate = "'.$beginDate.'";
            SET @endDate = "'.$endingDate.'";
            SET @Coa = "'.$coa.'";
        ';

        $journal_detail = TrxJournalA::where('account_code', Coa::where('code', $coa)->first()->id)->first();

        $query = $this->queryGetData($coa);

        DB::connection()->getpdo()->exec($queryStatement);
        $data = DB::select($query);

        // $total = [];
        foreach ($data as $index => $item) {

            $data_coa = Coa::where('code', $item->AccountCode)->first();

            $data[$index]->currency = Currency::where('code', 'idr')->first();
            $data[$index]->rate = 1;

            if ($item->VoucherNo != 'Saldo Awal') {

                $journal = TrxJournal::where('uuid', $item->journal_uuid)->first();
                $journal_detail = TrxJournalA::where('voucher_no', $item->VoucherNo)
                    ->where('account_code', $data_coa->id)
                    ->firstOrFail(); 

                $journal_ref_coll_curr = null;
                $journal_ref_coll_rate = null;
                if ($journal->ref_collection) {
                    $journal_ref_coll_curr = $journal->ref_collection->currency;
                    $journal_ref_coll_rate = $journal->ref_collection->rate;
                }

                $data[$index]->Description = $journal_detail->description_2 ?? $journal_detail->description;

                $data[$index]->currency = $journal_ref_coll_curr ?? $journal->currency;

                if ($data[$index]->currency->code == 'idr') {
                    $data[$index]->rate = 1;
                } else {
                    $data[$index]->rate = $journal_ref_coll_rate ?? $journal->exchange_rate;
                }

            }

            $coa_type = $data_coa
            ->type->code;

            if ($index > 0) {
                $balance = $data[$index-1]->endingBalance;
            }else{
                $balance = $item->SaldoAwal;
            }

            $data[$index]->endingBalance = $this->getEndingBalance(
                $balance, $coa_type, $item
            );

            $link = 'javascript:;';
            if ($item->journal_uuid and $item->journal_uuid != " ") {
                $link = route('journal.print')."?uuid=$item->journal_uuid";
            }

            if ($data[$index]->rate == 0 or ! $data[$index]->rate) {
                $data[$index]->rate = 1;
            }

            $journal_ref = TrxJournal::where('voucher_no', $item->VoucherNo)->first();
            $project_number = null;
            $po_number = null;
            if ($journal_ref) {

                $project = @$journal_ref->ref_collection->project;
                $purchase_order = @$journal_ref->ref_collection->purchase_order;

                if ($project) {
                    $project_number = $project->code;
                }

                if ($purchase_order) {
                    $po_number = $purchase_order->number;
                }
            }

            $data[$index]->voucher_linked = '<a href="'.$link.'">'.$item->VoucherNo.'</a>';
            $data[$index]->project_number = $project_number;
            $data[$index]->po_number = $po_number;
            $data[$index]->foreign_total = (($data[$index]->Debit != 0)? $data[$index]->Debit: $data[$index]->Credit) / ($data[$index]->rate);

            $ending_balance = $item->endingBalance;
        }

        $collection = collect($data);
        $data = [];
        $data['data'] = $collection;

        $data['total']['local'] = [
            'Total Debit' => $data['data']->sum('Debit'),
            'Total Credit' => '-'.$data['data']->sum('Credit'),
            'Total Ending Balance' => $ending_balance ?? 0,
        ];

        $data_group_by_currency = $data['data']
            ->groupBy('currency.code')->map(function($row) {
                return $row->sum('foreign_total');
            });

        $data['total']['foreign'] = [];

        foreach ($data_group_by_currency as $group_index => $group_row) {
            if ($group_index == 'idr') {
                continue;
            }

            $data['total']['foreign'][$group_index]['currency'] = Currency::where('code', $group_index)->first();
            $data['total']['foreign'][$group_index]['amount'] = ($total_foreign[$group_index]['amount'] ?? 0) + $group_row;
        }

        return $data;
    }

    public function convertDate($date)
    {
        $tmp_date = explode('-', $date);

        $start = new Carbon(str_replace('/', "-", trim($tmp_date[0])));
        $startDate = $start->format('Y-m-d');

        $end = new Carbon(str_replace('/', "-", trim($tmp_date[1])));
        $endDate = $end->format('Y-m-d');

        return [
            $startDate,
            $endDate
        ];
    }

    public function showDatatables(Request $request)
    {
        $_data = $this->getData(
            $request->beginDate,
            $request->endingDate,
            $request->coa
        );

        for ($i=0; $i < count($_data); $i++) {
            $arr = $_data[$i];

            $_data[$i]->type = Coa::where(
                'code',
                $arr->AccountCode
            )->first()->type->code;

            if ($_data[$i]->type == 'activa') {
                $_data[$i]->SaldoAkhir = @$_data[$i-1]->SaldoAkhir + $arr->Debit - $arr->Credit;
            }

            if ($_data[$i]->type == 'pasiva') {
                $_data[$i]->SaldoAkhir = @$_data[$i-1]->SaldoAkhir - $arr->Debit + $arr->Credit;
            }

            if ($_data[$i]->type == 'ekuitas') {
                $_data[$i]->SaldoAkhir = @$_data[$i-1]->SaldoAkhir + $arr->Credit - $arr->Debit;
            }

            if ($_data[$i]->type == 'pendapatan') {
                $_data[$i]->SaldoAkhir = @$_data[$i-1]->SaldoAkhir + $arr->Credit - $arr->Debit;
            }

            if ($_data[$i]->type == 'biaya') {
                $_data[$i]->SaldoAkhir = @$_data[$i-1]->SaldoAkhir + $arr->Debit - $arr->Credit;
            }
        }

        $data = $alldata = $_data;

        $datatable = array_merge([
            'pagination' => [], 'sort' => [], 'query' => []
        ], $_REQUEST);

        $filter = isset($datatable['query']['generalSearch']) &&
            is_string($datatable['query']['generalSearch']) ?
            $datatable['query']['generalSearch'] : '';

        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (bool) preg_grep("/$filter/i", (array) $a);
            });

            unset($datatable['query']['generalSearch']);
        }

        $query = isset($datatable['query']) &&
            is_array($datatable['query']) ? $datatable['query'] : null;

        if (is_array($query)) {
            $query = array_filter($query);

            foreach ($query as $key => $val) {
                $data = $this->list_filter($data, [$key => $val]);
            }
        }

        $sort  = !empty($datatable['sort']['sort']) ?
            $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ?
            $datatable['sort']['field'] : 'RecordID';

        $meta    = [];
        $page    = !empty($datatable['pagination']['page']) ?
            (int) $datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ?
            (int) $datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data);

        usort($data, function ($a, $b) use ($sort, $field) {
            if (!isset($a->$field) || !isset($b->$field)) {
                return false;
            }

            if ($sort === 'asc') {
                return $a->$field > $b->$field ? true : false;
            }

            return $a->$field < $b->$field ? true : false;
        });

        if ($perpage > 0) {
            $pages  = ceil($total / $perpage);
            $page   = max($page, 1);
            $page   = min($page, $pages);
            $offset = ($page - 1) * $perpage;

            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];

        if (
            isset($datatable['requestIds']) &&
            filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN))
        {
            $meta['rowIds'] = array_map(function ($row) {
                return $row->RecordID;
            }, $alldata);
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        $result = [
            'meta' => $meta + [
                'sort'  => $sort,
                'field' => $field,
            ],
            'data' => $data,
        ];

        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function print(Request $request)
    {
        ini_set('max_execution_time', '-1');
        ini_set('memory_limit', '-1');

        $code = explode(',', $request->data);
        $coa = Coa::whereIn('code', $code)->get();

        if (count($coa) < 1) {
            return redirect()->back()->with(['errors' => 'Coa not found']);
        }

        $date = $this->convertDate($request->date);

        $beginDate = $date[0];
        $endingDate = $date[1];

        for ($i=0; $i < count($coa); $i++) {

            $get_data = $this->getData(
                    $beginDate, $endingDate, $coa[$i]->code
                );

            $data_coa[] = $get_data;
        }

        $data_coa = array_values(array_filter($data_coa));

        foreach ($data_coa as $data_coa_row) {
            foreach ($data_coa_row['data'] as $data_row) {
                $data_row->description_formated = $data_row->Description_2 ?? $data_row->Description;
            }
        }

        $data = [
            'data' => $data_coa,
            'beginDate' => $beginDate,
            'endingDate' => $endingDate,
            'coa' => $coa,
            'carbon' => Carbon::class,
            'controller' => new Controller()
        ];

        $pdf = \PDF::loadView('formview::general-ledger-docs', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function export(Request $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('set_time_limit', '-1');
        ini_set('max_execution_time', '-1');

        $code = explode(',', $request->data);
        $coa = Coa::whereIn('code', $code)->get();

        if (count($coa) < 1) {
            return redirect()->back()->with([
                'errors' => 'Coa not found'
            ]);
        }

        $date = $this->convertDate($request->date);

        $beginDate = $date[0];
        $endingDate = $date[1];

        for ($i=0; $i < count($coa); $i++) {

            $data_coa[] = $this->getData(
                $beginDate, $endingDate, $coa[$i]->code
            );

        }

        $data = [
            'data' => $data_coa,
            'beginDate' => $beginDate,
            'endingDate' => $endingDate,
            'coa' => $coa,
            'carbon' => Carbon::class,
            'controller' => new Controller(),
            'total_foreign' => 0,
            'total_debit' => 0,
            'total_credit' => 0,
            'total_ending_balance' => 0,
        ];

        return Excel::download(new GLExport($data), 'GL.xlsx');
    }
}
