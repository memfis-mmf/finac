<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TrxBS as BS;
use memfisfa\Finac\Model\TrxJournal as Journal;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Request\BSUpdate;
use memfisfa\Finac\Request\BSStore;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Approval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use memfisfa\Finac\Model\TypeJurnal;

class TrxBSController extends Controller
{
    public function index()
    {
        return redirect()->route('bs.create');
    }

    public function approve(Request $request)
    {
		$bs = BS::where('uuid', $request->uuid);

		$header = $bs->first();

        if ($header->approve) {
            return [
                'status' => false,
                'message' => 'Document already approved'
            ];
        }

		$detail[] = (object) [
			'code' => $header->coad
		];

		$detail[] = (object) [
			'code' => $header->coac
		];

        $header->approvals()->save(new Approval([
            'approvable_id' => $header->id,
            'conducted_by' => Auth::id(),
            'note' => @$request->note,
            'is_approved' => 1
        ]));

		Journal::insertFromBS($header, $detail);

		$bs->update([
			'approve' => 1
		]);

        return response()->json($bs->first());
    }

	public function getType(Request $request)
	{
		return response()->json(TypeJurnal::all());
	}

	public function getCurrency(Request $request)
	{
		return response()->json(Currency::all());
	}

    public function create()
    {
        return view('bondview::index');
    }


	public function getTypeJson()
	{
		$bsType = TypeJurnal::where('name', 'GENERAL JOURNAL')
			->orWhere('name', 'JOURNAL ADJUSTMENT')
			->get();

		$type = [];

		for ($i = 0; $i < count($bsType); $i++) {
			$x = $bsType[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

	public function bsaStore(Request $request)
	{
        $employee = Employee::where('uuid', $request->id_employee)
            ->firstOrFail();

        $request->request->add([
            'id_employee' => $employee->id
        ]);

        $bs = BS::create($request->all());

        return $bs;
	}

    public function store(Request $request)
    {
        $request->validate([
            'id_employee' => 'required',
            'transaction_date' => 'required',
            'date_return' => 'required',
            'value' => 'required|numeric',
            'coac' => 'required',
            'coad' => 'required',
        ], [
            'id_employee.required' => 'Person cannot be empty',
            'transaction_date.required' => 'Date cannot be empty',
            'date_return.required' => 'Date returned cannot be empty',
            'value.required' => 'Amount cannot be empty',
            'coac.required' => 'Cash/Bank account cannot be empty',
            'coad.required' => 'Bond cannot be empty',
        ]);

        $employee = Employee::where('uuid', $request->id_employee)->firstOrFail();
        $transaction_date = Carbon::createFromFormat('d-m-Y', $request->transaction_date);
        $date_return = Carbon::createFromFormat('d-m-Y', $request->date_return);

        if ($date_return < $transaction_date) {
            return [
                'status' => false,
                'message' => 'Date return cannot be less than transaction date'
            ];
        }

        $request->merge([
            'id_employee' => $employee->id,
            'transaction_date' => $transaction_date,
            'date_return' => $date_return,
        ]);

		/*
		 *coac itu yang bank
		 *coad itu yang bond
		 */

		$request->request->add([
			'closed' => 0
		]);
		$data = $request->all();
		$data['transaction_number'] = BS::generateCode('BSTR');

        BS::create($data);

        return [
            'status' => true,
            'message' => 'Data Saved',
            'redirect' => route('bs.index')
        ];
    }

    public function edit(Request $request)
    {
		$data['data'] = BS::where('uuid', $request->bs)->first();
		$data['employee'] = Employee::orderBy('id', 'desc')->get();

        if ($data['data']->approve) {
            return [
                'status' => false,
                'message' => 'Document already approved'
            ];
        }

		if ($data['data']->approve) {
			return redirect()->back();
		}

        return view('bondview::edit', $data);
    }

    public function update(BSUpdate $request, BS $bs)
    {
        if ($bs->approve) {
            return [
                'status' => false,
                'message' => 'Document already approved'
            ];
        }

		$request->request->add([
			'closed' => 0
		]);

        $bs->update($request->all());

        return response()->json($bs);
    }

    public function destroy(BS $bs)
    {
        if ($bs->approve) {
            return [
                'status' => false,
                'message' => 'Document already approved'
            ];
        }

        $bs->delete();

        return response()->json($bs);
    }

    public function api()
    {
        $bsdata = BS::all();

        return json_encode($bsdata);
    }

    public function apidetail(BS $bs)
    {
        return response()->json($bs);
    }

    public function datatables()
    {
		$data = BS::with(['employee']);

        return datatables()
            ->of($data)
            ->addColumn('action', function($row) {
                $html = '';
                if ($row->approve) {
                    $html =
                        '<a href="'.route('bs.print', $row->uuid).'"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                            title="Print"
                            data-uuid="'.$row->uuid.'">
                            <i class="la la-print"></i>
                        </a>';

                    return $html;
                }

                $html =
                    '<a href="'.route('bs.edit', $row->uuid).'"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit"
                        title="Edit"
                        data-uuid="'.$row->uuid.'">
                        <i class="la la-pencil"></i>
                    </a>';
                $html .=
                    '<a href="javascript:;"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete"
                        title="Delete"
                        data-uuid=t.uuid>
                        <i class="la la-trash"></i>
                    </a>';
                $html .=
                    '<a href="javascript:;"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve"
                        title="Approve"
                        data-uuid="'.$row->uuid.'">
                        <i class="la la-check"></i>
                    </a>';

                return $html;
            })
            ->escapeColumns([])
            ->make();
    }

	public function print(Request $request)
	{
		$bs = BS::where('uuid', $request->uuid)->first();
		$bsa = $bs->bsa;

		if ($this->checkBalance($bsa)) {
			return redirect()->route('bs.index')->with([
				'errors' => 'Debit and Credit not balance'
			]);
		}

		$debit = 0;
		$credit = 0;

		for ($i = 0; $i < count($bsa); $i++) {
			$x = $bsa[$i];
			$debit += $x->debit;
			$credit += $x->credit;
		}

		$data = [
			'bs' => $bs,
			'bsa' => $bsa,
			'debit' => $debit,
			'credit' => $credit,
		];

        $pdf = \PDF::loadView('formview::view-bs', $data);
        return $pdf->stream();
	}
}
