<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Sells\Sell;
use NumberFormatter;
use Twilio\Rest\Client;
use App\SalesCollection;
use App\Events\SaleEvent;
use App\SellCollectionHead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Sells\InstallmentList;
use App\SalesCollectionDetails;
use App\Mail\SalesCollectionMail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Events\SaleCollectionEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Notification;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Notifications\SalesCollectionNotificiation;

class SalesCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:salesCollection-view|salesCollection-create|salesCollection-edit|salesCollection-delete', ['only' => ['index','show']]);
        $this->middleware('permission:salesCollection-create', ['only' => ['create','store']]);
        $this->middleware('permission:salesCollection-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:salesCollection-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $salesCollections = SalesCollection::with('salesCollectionDetails', 'sell',  'sell.apartment.project')->latest()->get();
        return view('sales.salesCollections.index', compact('salesCollections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType='create';
        $paymentTypes = SellCollectionHead::pluck('name', 'name');
        $paymentModes = ['Cash' => 'Cash','Cheque' => 'Cheque','Pay Order' => 'Pay Order','DD' => 'DD','TT' => 'TT','Online Bank Transfer' => 'Online Bank Transfer','Adjustment' => 'Adjustment'];
        $clients = [];
        return view('sales.salesCollections.create', compact('formType', 'paymentTypes', 'paymentModes', 'clients'));
    }

    public function store(Request $request)
    {
    //    $request->dd();
        try{
            $collectionData = $request->only('sell_id','received_date','received_amount','payment_mode','source_name','transaction_no','dated','remarks');
            $collectionData['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('salesCollection') : null;
            $collectionDetailData = array();
            foreach($request->particular as  $key => $data){
                $collectionDetailData[] = [
                    'particular'=>$request->particular[$key],
                    'amount'=>$request->amount[$key],
                    'installment_no'=>$request->installment_no[$key],
                    'installment_composite'=>$request->installment_composite[$key],
                ];
            }
            DB::transaction(function()use($collectionData, $collectionDetailData, &$salesCollection){
                $salesCollection = SalesCollection::create($collectionData);
                $salesCollection->salesCollectionDetails()->createMany($collectionDetailData);
            });

//            $client = $salesCollection->sell->sellClient->client;
            $client = $salesCollection->sell->sellClient->client;
            // Mail::to($client)->send(new SalesCollectionMail($salesCollection));
            Notification::send($client, new SalesCollectionNotificiation($salesCollection));


            // $event->salesCollection->sell->sellClient->client->notify(new SalesCollectionNotificiation($event->salesCollection));

        // return (new SalesCollectionMail($this->salesCollection));
            // Notification::send($client, new SalesCollectionNotificiation($salesCollection));

            return redirect()->route('salesCollections.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(SalesCollection $salesCollection)
    {
        $salesCollection = SalesCollection::with('salesCollectionDetails', 'sell.sellClient.client',  'sell.apartment.project')->where('id', $salesCollection->id)->firstOrFail();
        return view('sales.salesCollections.show', compact('salesCollection'));
    }

    public function edit(SalesCollection $salesCollection)
    {

        $formType='edit';
        $paymentTypes = SellCollectionHead::pluck('name', 'name');
        $paymentModes = ['Cash' => 'Cash','Cheque' => 'Cheque','Pay Order' => 'Pay Order','DD' => 'DD','TT' => 'TT','Online Bank Transfer' => 'Online Bank Transfer','Adjustment' => 'Adjustment'];

        $projectId = $salesCollection->sell->apartment->project_id;
        $sells = Sell::with('apartment:id,name,project_id','apartment.project:id,name', 'sellClient.client:id,name')
            ->whereHas('apartment', function($q)use($projectId){
                $q->where('project_id', $projectId);
            })->get(['id','apartment_id']);
        $clients = [];
        foreach($sells as $sell){
            $clients[$sell->id]=$sell->sellClient->client->name." [Apartment: ".$sell->apartment->name."]";
        }
//dd($clients, $paymentModes);
        return view('sales.salesCollections.create', compact('formType', 'paymentTypes', 'paymentModes', 'salesCollection', 'clients'));
    }

    public function update(Request $request, SalesCollection $salesCollection)
    {
        try{
            $collectionData = $request->only('sell_id','received_date','received_amount','payment_mode','source_name','transaction_no','dated','remarks');
            if($request->hasFile('attachment')){
                file_exists(asset($salesCollection->attachment)) && $salesCollection->attachment ? unlink($salesCollection->attachment) : null;
                $collectionData['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('salesCollection') : null;
            }
            $collectionDetailData = array();
            foreach($request->particular as  $key => $data){
                $collectionDetailData[] = [
                    'particular'=>$request->particular[$key],
                    'amount'=>$request->amount[$key],
                    'installment_no'=>$request->installment_no[$key],
                    'installment_composite'=> $request->particular[$key] == "Installment" ? $request->installment_composite[$key] : null,
                ];
            }
//            dd($collectionDetailData);
            DB::transaction(function()use($collectionData, $collectionDetailData, $salesCollection){
                $salesCollection->update($collectionData);
                $salesCollection->salesCollectionDetails()->delete();
                $salesCollection->salesCollectionDetails()->createMany($collectionDetailData);
            });
            return redirect()->route('salesCollections.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(SalesCollection $salesCollection)
    {
        try{
            $salesCollection->delete();
            return redirect()->route('salesCollections.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function acknowledgement(SalesCollection $salesCollection, $type)
    {
        // $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        $amount = strval($salesCollection->received_amount);
        $inwords = 'Taka '.$this->bengaliTk($amount) .' Only.';
        $paidValue =  SalesCollectionDetails::whereHas('salesCollection', function ($q) use($salesCollection){
                $q->where('sell_id', $salesCollection->sell_id);
            })->whereIn('particular',['Booking Money','Down Payment','Installment'])
            ->sum('amount');
        $bmCollection = $salesCollection->sell->bookingMoneyCollections()
            ->whereHas('salesCollection', function ($q) use($salesCollection){
                $q->where('sales_collection_id', '!=',$salesCollection->id);
            })->get();
        $dpCollection = $salesCollection->sell->downpaymentCollections()
            ->whereHas('salesCollection', function ($q) use($salesCollection){
                $q->where('sales_collection_id', '!=', $salesCollection->id);
            })->get();
        $saleClients = $salesCollection->sell->sellClients()->where('stage',$salesCollection->sell->sellClient->stage)->get();
//        dd($dpCollection);
//        return view('salesCollections.acknowledgement', compact('salesCollection', 'bmCollection','dpCollection','inwords','paidValue'));

        if($type == 'customer-copy'){
            return  PDF::loadview('sales.salesCollections.acknowledgementCustomer', compact('saleClients','salesCollection', 'bmCollection','dpCollection','inwords','paidValue'))->stream('sales_collection_report_customer'.now()->format('d-m-Y').'.pdf');
        }else{
            return  PDF::loadview('sales.salesCollections.acknowledgement', compact('saleClients','salesCollection', 'bmCollection','dpCollection','inwords','paidValue'))->stream('sales_collection_report_office'.now()->format('d-m-Y').'.pdf');
        }
    }

    function bengaliTk($num) {
        $spell = new NumberFormatter(locale_get_default(), NumberFormatter::SPELLOUT);
        $num_in_words = '';

        $units = [
            10000000 => 'Crore',
            100000 => 'Lacs',
            1000 => 'Thousand',
        ];

        foreach ($units as $divisor => $unit) {
            if ($num >= $divisor) {
                $chunk = floor($num / $divisor);
                $num_in_words .= Str::title($spell->format($chunk)) . " $unit ";
                $num %= $divisor;
            }
        }

        if ($num > 0) {
            $num_in_words .= Str::title($spell->format($num));
        }

        return $num_in_words;
    }

}
