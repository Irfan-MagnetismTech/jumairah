<?php

namespace App\Http\Controllers\Sells;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentShiftingRequest;
use App\ParkingDetails;
use App\Sells\Apartment;
use App\Sells\ApartmentShifting;
use App\Sells\Sell;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApartmentShiftingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shiftings = ApartmentShifting::latest()->get();
        return view('sales.apartment-shiftings.index', compact('shiftings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients =[];
        $apartments = [];
        $months = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];
        return view('sales/apartment-shiftings.create',compact('clients','apartments','months'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentShiftingRequest $request)
    {
        try{
            $sale = Sell::where('id', $request->sale_id)->first();
            $sell_data = $request->only('old_project_id', 'sale_id','tf_percentage','transfer_fee','discount','new_project_id','new_apartment_id'
            ,'hand_over_date', 'new_apartment_size','new_apartment_rate','new_utility_no','new_utility_price','new_reserve_no','new_reserve_rate',
            'new_parking_no','new_parking_price');
            $sell_data['user_id'] = Auth::user()->id;
            $sell_data['old_apartment_id'] = $sale->apartment_id;
            $sell_data['old_apartment_size'] = $sale->apartment_size;
            $sell_data['old_apartment_rate'] = $sale->apartment_rate;
            $sell_data['old_utility_no'] = $sale->utility_no;
            $sell_data['old_utility_price'] = $sale->utility_price;
            $sell_data['old_reserve_no'] = $sale->reserve_no;
            $sell_data['old_reserve_rate'] = $sale->reserve_rate;
            $sell_data['old_parking_no'] = $sale->parking_no;
            $sell_data['old_parking_price'] = $sale->parking_price;
            $sell_data['old_total_value'] = $sale->total_value;
            $sell_data['new_total_value'] = $request->total_value;
            $sell_data['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('nameTransfer') : null;

            $saleUpdateData['hand_over_date'] = $request->hand_over_date;
            $saleUpdateData['project_id'] = $request->new_project_id;
            $saleUpdateData['apartment_id'] = $request->new_apartment_id;
            $saleUpdateData['apartment_size'] = $request->new_apartment_size;
            $saleUpdateData['apartment_rate'] = $request->new_apartment_rate;
            $saleUpdateData['utility_no'] = $request->new_utility_no;
            $saleUpdateData['utility_price'] = $request->new_utility_price;
            $saleUpdateData['reserve_no'] = $request->new_reserve_no;
            $saleUpdateData['reserve_rate'] = $request->new_reserve_rate;
            $saleUpdateData['parking_no'] = $request->new_parking_no;
            $saleUpdateData['parking_price'] = $request->new_parking_price;
            $saleUpdateData['total_value'] = $request->total_value;

            $sellParkingData = array();
            if($request->parking_composite) {
                foreach ($request->parking_composite as $key => $data) {
                    $sellParkingData[] = [
                        'parking_composite' => $request->parking_composite[$key],
                        'parking_rate'      => $request->parking_rate[$key],
                        'sell_id'           => $request->sale_id,
                    ];
                }
            }

            DB::transaction(function()use($sell_data, $sellParkingData, $saleUpdateData){
                $shifting = ApartmentShifting::create($sell_data);
                $client = $shifting->sale->sellClient->client->name;
                $project = $shifting->newProject->name;
                $apartment = $shifting->newApartment->name;
                $accountName = "$client - $project - $apartment";
                $shifting->apartmentShiftingDetails()->createMany($sellParkingData);
                $shifting->sale->account()->update(['account_name' => $accountName]);
                $shifting->sale->update($saleUpdateData);
                $shifting->sale->soldParking()->delete();
                $shifting->sale->soldParking()->createMany($sellParkingData);
            });
            return redirect()->route('apartment-shiftings.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(ApartmentShifting $apartmentShifting)
    {
        //
    }

    public function edit(ApartmentShifting $apartmentShifting)
    {
        $clients =[];
//        $sell = Sell::with('soldParking')->where('id', $apartmentShifting->sale_id)->first();
//        $project_id = $sell->apartment->project_id;
        $apartments = Apartment::where('project_id',$apartmentShifting->new_project_id)->pluck('name', 'id');
        $months = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];
        $unsoldParkings = ParkingDetails::whereHas('parking.project', function($q)use($apartmentShifting){
            $q->where('id', $apartmentShifting->new_project_id);
        })->whereDoesntHave('soldParking', function($q)use($apartmentShifting){
            $q->whereNotIn('parking_composite', $apartmentShifting->sale->soldParking->pluck('parking_composite'));
        })->pluck('parking_name', 'parking_composite');
        return view('sales/apartment-shiftings.create',compact('clients','apartments','months','apartmentShifting','unsoldParkings'));
    }

    public function update(Request $request, ApartmentShifting $apartmentShifting)
    {
        //
    }

    public function destroy(ApartmentShifting $apartmentShifting)
    {
        try{
            DB::transaction(function() use($apartmentShifting){
                $apartmentShifting->delete();
                $apartmentShifting->apartmentShiftingDetails()->delete();
            });
            return redirect()->route('apartment-shiftings.index')->with('message', 'Data has been Deleted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function approval(ApartmentShifting $apartmentShifting, $status)
    {
        $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
            $q->where('name','Apartment Shifting');
        })->whereDoesntHave('approvals',function ($q) use($apartmentShifting){
            $q->where('approvable_id',$apartmentShifting->id)->where('approvable_type',ApartmentShifting::class);
        })->orderBy('order_by','asc')->first();

        $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
            $q->where('name','Apartment Shifting');
        })->whereDoesntHave('approvals',function ($q) use($apartmentShifting){
            $q->where('approvable_id',$apartmentShifting->id)->where('approvable_type',ApartmentShifting::class);
        })->orderBy('order_by','desc')->first();

        $data = [
            'layer_key' => $approvalfirst->layer_key,
            'user_id' => auth()->id(),
            'status' => $status,
        ];

        $transection['voucher_type'] = 'Journal';
        $transection['transaction_date'] = date('d-m-Y',strtotime(now()));
        $transection['user_id'] = auth()->user()->id;

        DB::transaction(function () use ($approvallast, $apartmentShifting, $data, $transection) {
            $approvalData  = $apartmentShifting->approval()->create($data);
//            if ($approvalData->layer_key == $approvallast->layer_key && $approvalData->status == 'Approved') {
////                $transectionData = $nameTransfer->transaction()->create($transection);
//
//            }
        });

        return redirect()->route('apartment-shiftings.index')->with('message', "This Apartment Shifting  $status  Successfully");
    }
}
