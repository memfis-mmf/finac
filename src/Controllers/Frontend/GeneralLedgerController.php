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


class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('generalledgerview::index');
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

        $data = [
            'data' => $data_coa,
            'beginDate' => $beginDate,
            'endingDate' => $endingDate,
            'coa' => $coa,
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
            m_journal.code as AccountCode,
            m_journal.Name as Name,
            IFNULL(
            (select sum(debit-Credit) from trxjournala
            left join trxjournals on trxjournals.Voucher_No=trxjournala.Voucher_No
            where
            cast(trxjournals.Transaction_Date as date) < @startDate
            and
            trxjournala.account_code = m_journal.id
            )
            ,0)
            AS SaldoAwal,
            0 AS Debit,
            0 AS Credit,
            'Saldo Awal' AS Description
            FROM m_journal
            WHERE
            m_journal.description = 'Detail'
            and
            m_journal.code in (".$coa.")
            UNION ALL
            (SELECT
            trxjournals.transaction_date as TransactionDate,
            trxjournals.created_at as CreatedAt,
            trxjournals.voucher_no as VoucherNo,
            trxjournals.ref_no as RefNo,
            m_journal.code as AccountCode,
            m_journal.Name as Name,
            0 AS SaldoAwal ,
            trxjournala.Debit AS Debit,
            trxjournala.Credit AS Credit,
            trxjournala.description AS Description
            from
            trxjournals
            left join trxjournala
            on trxjournals.voucher_no = trxjournala.voucher_no
            left join m_journal
            on trxjournala.account_code = m_journal.id
            where cast(trxjournals.transaction_date as date) between @startDate and @endDate";

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

        $query = $this->queryGetData($coa);

        DB::connection()->getpdo()->exec($queryStatement);
        $data = DB::select($query);

        foreach ($data as $index => $item) {
            $coa_type = Coa::where('code', $item->AccountCode)->first()
            ->type->code;

            if ($index > 0) {
                $balance = $data[$index-1]->endingBalance;
            }else{
                $balance = $item->SaldoAwal;
            }

            $data[$index]->endingBalance = $this->getEndingBalance(
                $balance, $coa_type, $item
            );
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
        ];

        $pdf = \PDF::loadView('formview::general-ledger-docs', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function export(Request $request)
    {
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
        ];

        return Excel::download(new GLExport($data), 'GL.xlsx');
    }
}