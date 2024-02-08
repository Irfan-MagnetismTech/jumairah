<?php

namespace App\Http\Controllers\Sells;

use App\Team;
use App\User;
use App\Parking;

use Carbon\Carbon;
use App\Sells\Sell;
use App\TeamMember;
use App\Sells\Client;
use App\Mail\SellMail;
use App\ParkingDetails;
use App\SalesCollection;
use App\Sells\Apartment;
use App\Accounts\Account;
use App\Events\SaleEvent;
use App\Sells\SoldParking;
use App\Sells\Saleactivity;
use Illuminate\Http\Request;
use App\Sells\InstallmentList;
use App\SalesCollectionDetails;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SellsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Approval\ApprovalLayerDetails;
use App\Notifications\SaleNotification;
use Illuminate\Database\QueryException;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sellNameTransfer()
    {
        return view('sellNameTransfer.create');
    }

    function __construct()
    {
        $this->middleware('permission:sell-view|sell-create|sell-edit|sell-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sell-create', ['only' => ['create','store']]);
        $this->middleware('permission:sell-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sell-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
       $sells=Sell::with('sellClients', 'apartment.project')->latest()->get();
        return view('sales.sells..index', compact('sells'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType="create";
        $clients = Client::latest()->get();
        $currentUser = Auth::user();
        if($currentUser->hasAnyRole(['super-admin', 'admin', 'manager', 'authority'])){
            $employees = User::with('member')->whereHas('member')->pluck('name', 'id');
        }elseif($currentUser->head){
            $employees = User::with('member.team')->whereHas('member.team', function($q)use($currentUser){
                $q->where('head_id', $currentUser->id);
            })->orderBy('name')->pluck('name', 'id');
        }else{
            $employees = [];
        }
        $months = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];
        $apartments = [];
        return view('sales.sells.create', compact('formType', 'clients','apartments', 'employees','months'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellsRequest $request){
    //    dd($request->all());
        try{
            $sell_data = $request->except('name','contact', 'client_id', 'project_name','parking_composite','parking_rate','installment_no','installment_date','installment_amount');
//            Sell::create($data);
//            $sell_data[''] =Auth::user()->id;
            $sell_data['entry_by'] = Auth::user()->id;
            $sellParkingData = array();
            if($request->parking_composite) {
                foreach ($request->parking_composite as $key => $data) {
                    $sellParkingData[] = [
                        'parking_composite' => $request->parking_composite[$key],
                        'parking_rate' => $request->parking_rate[$key],
                    ];
                }
            }
            $clientData = array();
            foreach($request->client_id as  $key => $data){
                $clientData[] = ['client_id'=>$data];
            }
            DB::transaction(function()use($sell_data, $sellParkingData, &$sell,$clientData, $request){
                $sell = Sell::create($sell_data);
                $sell->soldParking()->createMany($sellParkingData);
                $sell->sellClients()->createMany($clientData);

                $saleclients = $sell->sellClients()->get();
                foreach ($saleclients as $saleclient){
                    if($saleclient->client->lead()->exists()){
                        $saleclient->client->lead()->update(['is_sold'=>1]);
                    }
                }
//                dd();
                $sell->installmentList()->createMany(
                    collect(request()->installment_no)->map(function($item, $key) use ($sell, $request){
                        return [
                            'installment_composite'=>'S'.$sell->id.'-I'.request()->installment_no[$key],
                            'installment_no'=>request()->installment_no[$key],
                            'installment_date'=>request()->installment_date[$key],
                            'installment_amount'=>request()->installment_amount[$key],
                        ];
                    })->toArray()
                );

                $parentAccount = Account::where('balance_and_income_line_id',35)->where('account_name','like','Installment')->first();

                $accountData['account_name']= $sell->sellClients->first()->client->name.' - '.request()->project_name.' - '.$sell->apartment->name;
                $accountData['account_type']= 2;
                $accountData['account_code']= "26-33-35-".$sell->id;
                $accountData['balance_and_income_line_id']= 35;
                $accountData['parent_account_id']= $parentAccount->id;
                $sell->account()->create($accountData);
            });

//            event(new SaleEvent($sell));

            return redirect()->route('sells.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function show(Sell $sell)
    {
        $payableAmount =0; $deductionAmount=0; $payables =[];
        if($sell->saleCancellation){
            $payableAmount = $sell->saleCancellation->account->ledgers->sum('cr_amount');
            $deductionAmount = $sell->saleCancellation->deducted_amount;
            $payables = $sell->saleCancellation->account->ledgers()->whereNotNull('dr_amount')->get();
        }

        $receivable =
        // return  SalesCollectionDetails::orderByDate(
        //     SalesCollection::select('received_date')
        //     ->whereColumn('sales_collection_id', 'destinations.id')
        //     ->orderByDesc('received_date')
        // )->get();

        $sell = Sell::
            with(
            'salesCollections.lastApproval',
            'salesCollections.salesCollectionDetails',
            'installmentList.installmentCollections',
            'bookingMoneyCollections',
            'downpaymentCollections',
            'sellClients',
            'sellClient')
            ->where('id', $sell->id)
            ->firstOrFail();

        $saleClients = $sell->sellClients()->where('stage',$sell->sellClient->stage)->get();
        $services =  SalesCollectionDetails::whereHas('salesCollection', function ($q) use($sell){
            $q->where('sell_id', $sell->id);
        })
        ->whereNotIn('particular',['Booking Money','Down Payment','Installment'])
        ->get();

        // dd($services);

        // $sell = Sell::with('installmentList.installmentCollections')
        //     ->where('id', $sell->id)
        //     ->firstOrFail();
        // return $sell->installmentList->take(2)->last();


        // dd($sell->toArray());
        return view('sales.sells..show', compact('sell','saleClients','services','payableAmount','deductionAmount','payables'));
    }

    public function edit(Sell $sell)
    {
        $formType = "edit";
        $sell = Sell::with('soldParking')->where('id', $sell->id)->first();
        $project_id = $sell->apartment->project_id;
        $apartments = Apartment::where('project_id',$project_id)->pluck('name', 'id');

        $unsoldParkings = ParkingDetails::whereHas('parking.project', function($q)use($project_id){
            $q->where('id', $project_id);
        })->whereDoesntHave('soldParking', function($q)use($sell){
                $q->whereNotIn('parking_composite', $sell->soldParking->pluck('parking_composite'));
        })->pluck('parking_name', 'parking_composite');

        $months = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12];

        $currentUser = Auth::user();
        if($currentUser->hasAnyRole(['super-admin', 'admin', 'manager', 'authority'])){
            $employees = User::with('member')->whereHas('member')->pluck('name', 'id');
        }elseif($currentUser->head){
            $employees = User::with('member.team')->whereHas('member.team', function($q)use($currentUser){
                $q->where('head_id', $currentUser->id);
            })->orderBy('name')->pluck('name', 'id');
        }else{
            $employees = [];
        }

        $saleClients = $sell->sellClients()->whereNull('name_transfer_id')->get();
        return view('sales.sells..create', compact('formType', 'sell', 'saleClients','apartments','unsoldParkings', 'employees','months'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function update(SellsRequest $request, Sell $sell)
    {
        try{
            $sell_data = $request->except('name','contact','client_id', 'project_name','parking_composite',
                        'parking_rate','installment_no','installment_date','installment_amount');

            $clientData = array();
            if (!empty($request->client_id)){
                foreach($request->client_id as  $key => $data){
                    $clientData[] = [
                        'client_id'=>$data,
                    ];
                }
            }

            $sellParkingData = array();
            if($request->parking_composite) {
                foreach ($request->parking_composite as $key => $data) {
                    $sellParkingData[] = [
                        'parking_composite' => $request->parking_composite[$key],
                        'parking_rate' => $request->parking_rate[$key],
                    ];
                }
            }

            DB::transaction(function()use($sell,$sell_data,$sellParkingData,$clientData){
                $sell->update($sell_data);
                if($sell->nameTransfers->isEmpty()){
                    $saleclients = $sell->sellClients()->get();
                    foreach ($saleclients as $saleclient){
                        if($saleclient->client->lead()->exists()){
                            $saleclient->client->lead()->update(['is_sold'=>0]);
                        }
                    }
                    $sell->sellClients()->delete();
                    $sell->sellClients()->createMany($clientData);
                    foreach ($sell->sellClients()->get() as $saleclient){
                        if($saleclient->client->lead()->exists()){
                            $saleclient->client->lead()->update(['is_sold'=>1]);
                        }
                    }
                }
                $sell->soldParking()->delete();
                $sell->soldParking()->createMany($sellParkingData);
                $sell->installmentList()->delete();
                $sell->installmentList()->createMany(
                    collect(request()->installment_no)->map(function($item, $key) use ($sell){
                        return [
                            'installment_composite'=>'S'.$sell->id.'-I'.request()->installment_no[$key],
                            'installment_no'=>request()->installment_no[$key],
                            'installment_date'=>request()->installment_date[$key],
                            'installment_amount'=>request()->installment_amount[$key],
                        ];
                    })->toArray()
                );

                $parentAccount = Account::where('balance_and_income_line_id',35)->where('account_name','like','Installment')->first();

                $accountData['account_name']= $sell->sellClients->first()->client->name.' - '.request()->project_name.' - '.$sell->apartment->name;
                $accountData['account_type']= 2;
                $accountData['account_code']= "26-33-35-".$sell->id;
                $accountData['balance_and_income_line_id']= 35;
                $accountData['parent_account_id']= $parentAccount->id;
                $sell->account()->updateOrCreate(
                    ['accountable_type'=>Sell::class,'accountable_id'=>$sell->id],
                    $accountData
                );
            });
            return redirect()->route('sells.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sell $sell)
    {
        try{
            if($sell->salesCollections->isNotEmpty()){
                return back()->withErrors(["There are some SaleCollection record who belongs this Sell. Please remove them first."]);
            }
            if ($sell->nameTransfers->isNotEmpty()){
                return back()->withErrors(["There are some Name Transfer record who belongs this Sell. Please remove them first."]);
            }
            DB::transaction(function () use($sell){
                foreach ($sell->sellClients()->get() as $saleclient){
                    if($saleclient->client->lead()->exists()){
                        $saleclient->client->lead()->update(['is_sold'=> 0]);
                    }
                }
                $sell->delete();
            });
            return redirect()->route('sells.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function salesperformance(Request $request)
    {
        $year = $request->year ? Carbon::createFromFormat('Y', $request->year) : now();
        $teams = Team::with('members.user.sells')->orderBy('name')->get();
        $teamNames = $teams->pluck(0,'name');

        $salesGroupByMonths = Sell::with('user.member.team')->whereYear('sell_date', $year)->orderBy('sell_date')->get(['sell_date', 'id', 'sell_by'])
            ->groupBy(function($item){
                return Carbon::parse($item->sell_date)->format('Y/m');
            });

        $salesGroupByTeams = collect();
        foreach ($salesGroupByMonths as $key => $group) {
            $salesGroupByTeams[$key] = $group->groupBy('user.member.team.name')->map(function($item, $key){
                    return $item->count();
            });
        } // inside of every month grouped Team Wise.

        $allTeamSales = $salesGroupByTeams->map(function($item, $key)use($teamNames){
            $lal = $teamNames->merge($item)->map(function($item){
                return $item > 0 ? $item : 0;
            });
            return [$key => $lal->join(',')];
        })->collapse()->toArray(); // merge all teams names.

        return view('sales.sells..salesperformance', compact('teams', 'allTeamSales', 'teamNames'));
    }

    public function saleactivity(Sell $sell)
    {
        $sell = $sell->load('saleactivities');
        $saleClients = $sell->sellClients()->where('stage',$sell->sellClient->stage)->get();
        return view('sales.sells..saleactivity', compact('sell','saleClients'));
    }

    public function paymentDetailsPdf(Sell $sell)
    {
        $saleClients = $sell->sellClients()->where('stage',$sell->sellClient->stage)->get();
        return PDF::loadview('sales.projects.paymentDetailspdf', compact('sell','saleClients'))
            ->stream('paymentDetailspdf.pdf');
    }

    public function sellsApproval(Sell $sell, $status){
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($sell){
                $q->where([['name','Sell'],['department_id',$sell->user->department_id]]);
            })->whereDoesntHave('approvals',function ($q) use($sell){
                $q->where('approvable_id',$sell->id)->where('approvable_type',Sell::class);
            })->orderBy('order_by','asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            $sell->approval()->create($data);

            return redirect()->route('sells.index')->with('message', "Sell of apartment {$sell->apartment->name} has been approved.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
