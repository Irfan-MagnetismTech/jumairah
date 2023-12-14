<?php

namespace App\Http\Controllers\Procurement;

use App\Approval\Approval;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Approval\ApprovalLayer;
use App\Procurement\GeneralBill;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Procurement\MaterialReceive;
use Illuminate\Support\Facades\Crypt;
use App\Approval\ApprovalLayerDetails;
use function PHPUnit\Framework\isNull;
use App\Procurement\GeneralBillDetails;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\GeneralBillRequest;

class GeneralBillController extends Controller {
	private const STORE_PATH = "general_bill";
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$generalBills = \App\Procurement\GeneralBill::latest()->get();
		return view('procurement.generalBill.index', compact( 'generalBills') );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$formType = "create";
		return view('procurement.generalBill.create', compact( 'formType') );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( GeneralBillRequest $request ) {
		try {
			$generalBillData = $request->only( 'date', 'total_amount', 'mpr_id', 'mrr_id' );
			$generalBillData['user_id'] = auth()->id();
			$generalBillData['cost_center_id'] = $request->project_id;

			DB::transaction( function () use ( $generalBillData, $request ) {
				$generalBill = GeneralBill::create( $generalBillData );
				$imgname = null;
				foreach ( $request->account_id as $key => $value ) {
					if ( isset( $request->file( 'image' )[$key] ) ) {
						$images = $request->file( 'image' )[$key];
						$imagesName = Str::random( 8 ) . time() . '.' . $images->extension();
						$imgname = $request->file( 'image' )[$key]->storeAs( self::STORE_PATH, $imagesName );
					}elseif(isNull($request->file( 'image' ))){
                        $imgname = null;
                    }
                    elseif(!array_key_exists($key, $request->file( 'image' ))){
                        $imgname = null;
                    }
					$generalBillDetailsData = [
						'account_id'  => $request->account_id[$key],
						'description' => $request->description[$key],
						'remarks'     => $request->remarks[$key],
						'amount'      => $request->amount[$key],
						'attachment'  => $imgname,
					];
					$generalBill->generalbilldetails()->create( $generalBillDetailsData );
				}
			} );
			return redirect()->route( 'generalBill.index' )->with( 'message', 'Data has been inserted successfully' );
		} catch ( QueryException $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(GeneralBill $generalBill ) {
		return view('procurement.generalBill.show', compact('generalBill'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit( GeneralBill $generalBill ) {
		$formType = "edit";
		return view( 'procurement.generalBill.create', compact( 'generalBill', 'formType' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update( GeneralBillRequest $request, GeneralBill $generalBill ) {
		try {
			$generalBillData = $request->only( 'project_id', 'date', 'total_amount', 'mpr_id', 'mrr_id' );

			$generalBillDetailsData = [];
			DB::transaction( function () use ( $generalBillData, $request, $generalBill ) {
				$generalBill->update( $generalBillData );
				$imgname = null;
				$a = $generalBill->generalbilldetails->pluck( 'attachment' );
				foreach ( $request->account_id as $key => $value ) {
					if ( isset( $request->file( 'image' )[$key] ) ) {
						( Storage::exists( $generalBill->generalbilldetails[$key]->attachment ) && ( $generalBill->generalbilldetails[$key]->attachment != '' ) && ( $generalBill->generalbilldetails[$key]->attachment != null ) ) ? Storage::delete( $generalBill->generalbilldetails[$key]->attachment ) : null;
						$images = $request->file( 'image' )[$key];
						$imagesName = Str::random( 8 ) . time() . '.' . $images->extension();
						$imgname = $request->file( 'image' )[$key]->storeAs( self::STORE_PATH, $imagesName );
					} else {
						$imgname = $a[$key];
					}
					$generalBillDetailsData[] = [
						'account_id'     => $request->account_id[$key],
						'description' => $request->description[$key],
						'remarks'     => $request->remarks[$key],
						'amount'      => $request->amount[$key],
						'attachment'  => $imgname,
					];
				}
				$generalBill->generalbilldetails()->delete();
				$generalBill->generalbilldetails()->createMany( $generalBillDetailsData );
			} );

			return redirect()->route( 'generalBill.index' )->with( 'message', 'Data has been updated successfully' );
		} catch ( QueryException $e ) {
			return redirect()->back()->withInput()->withErrors( $e->getMessage() );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( GeneralBill $generalBill ) {
		try {
			$generalBill->delete();
			return redirect()->route( 'generalBill.index' )->with( 'message', 'Data has been deleted successfully' );
		} catch ( QueryException $e ) {
			return redirect()->route( 'generalBill.index' )->withErrors( $e->getMessage() );
		}
	}


    public function ShowFile($id){
        $generalBilldetail = GeneralBillDetails::findOrFail(Crypt::decryptString($id));
       if(Storage::exists($generalBilldetail->attachment)){
           $FilePath = $generalBilldetail->attachment;
           return response()->file(Storage::path($FilePath));
       }else{
        return redirect()->back()->withErrors('There is No attachment available');
       }
    }

    public function Approve(GeneralBill $generalBill, $status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($generalBill) {
                $q->where([['name', 'General Bill'], ['department_id', $generalBill->user->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($generalBill) {
                $q->where([['approvable_id', $generalBill->id], ['approvable_type', GeneralBill::class]]);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($generalBill) {
                $q->where([['name', 'General Bill'], ['department_id', $generalBill->user->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($generalBill) {
                $q->where([['approvable_id', $generalBill->id], ['approvable_type', GeneralBill::class]]);
            })->orderBy('order_by', 'desc')->first();

            $approvalData = $generalBill->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                return redirect()->route('generalBill.index')->with('message', "Bill $generalBill->id approved.");
            }
            return redirect()->route('generalBill.index')->with('message', "Bill $generalBill->id approved.");
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
