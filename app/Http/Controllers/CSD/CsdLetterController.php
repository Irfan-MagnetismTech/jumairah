<?php

namespace App\Http\Controllers\CSD;

use App\CSD\CsdLetter;
use App\CSD\MailRecords;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSD\CsdLetterRequest;
use App\Mail\CustomizeLetterToClient;
use App\SellsClient;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 
class CsdLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:csd-letter-view|csd-letter-create|csd-letter-edit|csd-letter-delete', ['only' => ['index','show']]);
        $this->middleware('permission:csd-letter-create', ['only' => ['create','store']]);
        $this->middleware('permission:csd-letter-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:csd-letter-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letters = CsdLetter::latest()->get();
        return view('csd.letter.index', compact('letters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $clients = [];
        $letter = [];
        return view('csd.letter.create', compact('formType', 'clients', 'letter'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CsdLetterRequest $letter)
    {
        
        try{
            $letter_data = $letter->only('letter_title', 'letter_date','project_id','address_word_one','sell_id','letter_subject','address_word_two','letter_body');

            DB::transaction(function()use($letter_data){
                CsdLetter::create($letter_data);
            });

            return redirect()->route('csd.letter.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CsdLetter $letter)
    {
        $letters = CsdLetter::where('id', $letter->id)->first();
        return view('csd.letter.show', compact('letters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CsdLetter $letter)
    {
        $formType = "edit";
        $clients = [];
        $client = CsdLetter::where('id', $letter->id)->first();
        return view('csd.letter.create', compact('formType', 'clients', 'letter', 'client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CsdLetterRequest $request, CsdLetter $letter)
    {
        try{
            $letter_data = $request->only('letter_title','letter_date','project_id','address_word_one','sell_id','letter_subject','address_word_two','letter_body');

            DB::transaction(function()use($letter_data, $letter){
                $letter->update($letter_data);
            });

            return redirect()->route('csd.letter.index')->with('message', 'Data has been updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CsdLetter $letter)
    {
        try{
            $letter->delete();
            return redirect()->route('csd.letter.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('csd.letter.create')->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $letters = CsdLetter::where('id', $id)->first();
        return \PDF::loadview('csd.letter.pdf', compact('letters'))->setPaper('A4', 'portrait')->stream('letter.pdf');
    }


    public function sendMail($id)
    {
        try {
            DB::transaction(function() use ($id) {
                $CsdLetterMail = CsdLetter::where('id', $id)->first();
                Mail::to($CsdLetterMail->client->email)
                    ->send(new CustomizeLetterToClient($CsdLetterMail)); 
                MailRecords::create($CsdLetterMail->toArray() );
            });
            return redirect()->route('csd.mail-records')->with('message', 'Mail has been send successfully');
        }catch(QueryException $e) {
            return redirect()->route('csd.letter.create')->withErrors($e->getMessage());
        }
    }

    public function mailRecords(){
        $mail_records = MailRecords::latest()->get();
        return view('csd.letter.mail-records', compact('mail_records'));
    }
}
