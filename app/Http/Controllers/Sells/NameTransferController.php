<?php

namespace App\Http\Controllers\Sells;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNameTransferRequest;
use App\Http\Requests\UpdateNameTransferRequest;
use App\SalesCollectionDetails;
use App\Sells\NameTransfer;
use App\Sells\Sell;
use App\SellsClient;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NameTransferController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:name-transfer-view|name-transfer-create|name-transfer-edit|name-transfer-delete', ['only' => ['index','show']]);
        $this->middleware('permission:name-transfer-create', ['only' => ['create','store']]);
        $this->middleware('permission:name-transfer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:name-transfer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $allData = NameTransfer::latest()->get();
        return view('sales/name-transfers.index',compact('allData'));
    }

    public function create()
    {
        $clients =[];
        return view('sales/name-transfers.create',compact('clients'));
    }

    public function store(StoreNameTransferRequest $request)
    {
        try{
            $sell_data = $request->except('name','contact','client_id');
            $sell_data['user_id'] = Auth::user()->id;
            $sell_data['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('nameTransfer') : null;
            $logsArray =[];
            foreach($request->client_id as  $key => $ladata){
                $logsArray[] = [
                    'name'=>$request->name[$key],
                    'contact'=> $request->contact[$key],
                    'client_id'=>$ladata,
                ];
            }
            $sell_data['details'] = $logsArray;
            $clientData = array();
            $OldClient = SellsClient::where('sell_id',$request->sale_id)->latest('id')->first();
            $stage= $OldClient->stage + 1;
            foreach($request->client_id as  $key => $data){
                $clientData[] = [
                    'client_id' => $data,
                    'sell_id' => $request->sale_id,
                    'stage' => $stage,
                    ];
            }
            DB::transaction(function()use($sell_data,$clientData, $request){
                $nameTransfer = NameTransfer::create($sell_data);
                $nameTransfer->saleClients()->createMany($clientData);

                $parentAccount = Account::where('balance_and_income_line_id',35)->where('account_name','like','Installment')->first();
                $accountData['account_name']= $nameTransfer->sale->sellClient->client->name.' - '.request()->project_name.' - '.$nameTransfer->sale->apartment->name;
                $accountData['account_type']= 2;
                $accountData['account_code']= "26-33-35-".$nameTransfer->id;
                $accountData['balance_and_income_line_id']= 35;
                $accountData['parent_account_id']= $parentAccount->id;
                $nameTransfer->account()->create($accountData);
            });
            return redirect()->route('name-transfers.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(NameTransfer $nameTransfer)
    {
        //
    }

    public function edit(NameTransfer $nameTransfer)
    {
        $clients =[];
        return view('sales/name-transfers.create', compact('clients','nameTransfer'));
    }

    public function update(StoreNameTransferRequest $request, NameTransfer $nameTransfer)
    {
        try{
            $sell_data = $request->except('name','contact','client_id','attachment');
            $logsArray =[];
            foreach($request->client_id as  $key => $ladata){
                $logsArray[] = [
                    'name'=>$request->name[$key],
                    'contact'=> $request->contact[$key],
                    'client_id'=>$ladata,
                ];
            }
            $sell_data['details'] = $logsArray;
            if($request->hasFile('attachment')){
                file_exists(asset($nameTransfer->attachment)) && $nameTransfer->attachment ? unlink($nameTransfer->attachment) : null;
                $sell_data['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('nameTransfer') : null;
            }
            $clientData = array();
            DB::transaction(function()use($sell_data,$clientData, $request, $nameTransfer){
                $nameTransfer->update($sell_data);
                $nameTransfer->saleClients()->delete();
                $OldClient = SellsClient::where('sell_id',$request->sale_id)->latest('id')->first();

                $stage= $OldClient->stage + 1;
                foreach($request->client_id as  $key => $data){
                    $clientData[] = [
                        'client_id'=>$data,
                        'sell_id'=> $request->sale_id,
                        'stage'=>$stage,
                    ];
                }
                $nameTransfer->saleClients()->createMany($clientData);

                $accountData['account_name']= $nameTransfer->sale->sellClient->client->name.' - '.request()->project_name.' - '.$nameTransfer->sale->apartment->name;
                $nameTransfer->account()->update($accountData);
            });
            return redirect()->route('name-transfers.index')->with('message', 'Data has been Updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    public function destroy(NameTransfer $nameTransfer)
    {
        try{
            DB::transaction(function() use($nameTransfer){
                if(!empty($nameTransfer->account) && $nameTransfer->account->ledgers()->exists()){
                    return back()->withErrors(["This Name Transfer Has Transaction. Please remove the Transaction record first."]);
                }
                $nameTransfer->delete();
                $nameTransfer->saleClients()->delete();
                $nameTransfer->account()->delete();
            });
            return redirect()->route('name-transfers.index')->with('message', 'Data has been Deleted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function approval(NameTransfer $nameTransfer, $status)
    {
        $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
            $q->where('name','Name Transfer');
        })->whereDoesntHave('approvals',function ($q) use($nameTransfer){
            $q->where('approvable_id',$nameTransfer->id)->where('approvable_type',NameTransfer::class);
        })->orderBy('order_by','asc')->first();

        $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
            $q->where('name','Name Transfer');
        })->whereDoesntHave('approvals',function ($q) use($nameTransfer){
            $q->where('approvable_id',$nameTransfer->id)->where('approvable_type',NameTransfer::class);
        })->orderBy('order_by','desc')->first();

        $data = [
            'layer_key' => $approvalfirst->layer_key,
            'user_id' => auth()->id(),
            'status' => $status,
        ];

        $oldStage = $nameTransfer->sellClient->stage - 1;
        $newClientData = SellsClient::where('sell_id',$nameTransfer->sale_id)->where('stage',$oldStage)->oldest()->first();

        $transection['voucher_type'] = 'Journal';
        $transection['transaction_date'] = date('d-m-Y',strtotime(now()));
        $transection['user_id'] = auth()->user()->id;

        $paidValue =  SalesCollectionDetails::whereHas('salesCollection', function ($q) use($nameTransfer){
                $q->where('sell_id', $nameTransfer->sale_id);
            })->whereIn('particular',['Booking Money','Down Payment','Installment'])
                ->sum('amount');

        $project = $nameTransfer->sale->apartment->project;
        $apartment = $nameTransfer->sale->apartment->name;
        $clientName = $newClientData->client->name;
        $oldAccountName = "$clientName - $project->name - $apartment";
        $oldAccount = Account::where('balance_and_income_line_id',35)->where('account_name', 'like',"%$oldAccountName%")->first();

        $oldClient['account_id'] = $oldAccount->id;
        $oldClient['cost_center_id'] = $project->costCenter->id;
        $oldClient['dr_amount'] = $paidValue;
        $oldClient['pourpose'] = 'Name Transfer';

        $newClient['account_id'] = $nameTransfer->account->id;
        $newClient['cost_center_id'] = $project->costCenter->id;
        $newClient['cr_amount'] = $paidValue;
        $newClient['pourpose'] = 'Name Transfer';
//        dd($transection, $oldClient, $newClient);
        DB::transaction(function () use ($approvallast,$nameTransfer, $data, $transection, $oldClient, $newClient) {
            $approvalData  = $nameTransfer->approval()->create($data);
            if ($approvalData->layer_key == $approvallast->layer_key && $approvalData->status == 'Approved') {
                $transectionData = $nameTransfer->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($oldClient);
                $transectionData->ledgerEntries()->create($newClient);
            }
        });

        return redirect()->route('name-transfers.index')->with('message', "This Name Transfer  $status  Successfully");
    }
}
