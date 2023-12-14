<?php

namespace App\Http\Controllers\BD;

use App\BD\Source;
use App\BD\BdleadFollowUp;
use App\BD\BdFeasibilityFar;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;
use App\BD\BdFeasibilityFarChart;
use Illuminate\Support\Facades\DB;
use App\BD\BdLeadGenerationPicture;
use App\District;
use App\Division;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BD\BdLeadFollowupRequest;
use App\Http\Requests\BD\BdLeadGenerationRequest;
use App\Mouza;
use App\Thana;

class BdLeadGenerationController extends Controller
{
    private const STORE_PATH = "bdlead";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-lead-generation-view|bd-lead-generation-create|bd-lead-generation-edit|bd-lead-generation-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:bd-lead-generation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:bd-lead-generation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bd-lead-generation-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bd_lead_data = BdLeadGeneration::latest()->get();
        return view('bd.lead-generation.index', compact('bd_lead_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $land_under = [
            'PWD'                           => 'PWD',
            'CDA'                           => 'CDA',
            'NHA'                           => 'NHA',
            'Nasirabad Properties LTD'      => 'Nasirabad Properties LTD',
            'Co-operative Housing Society'  => 'Co-operative Housing Society',
            'Private Land'                  => 'Private Land'
        ];
        $lead_stage = [
            'Primary Stage'         => 'Primary Stage',
            'Maturing Stage'        => 'Maturing Stage',
            'FInalizing Stage'      => 'FInalizing Stage',
            'Settled'               => 'Settled'
        ];
        $category = [
            'Residential Building'                                  =>  'Residential Building',
            'Residential Hotel'                                     =>  'Residential Hotel',
            'Residential cum Commercial'                            =>  'Residential cum Commercial',
            'Commercial'                                            =>  'Commercial',
            'School, College, University'                           =>  'School, College, University',
            'Primary School & Kinder Garten'                        =>  'Primary School & Kinder Garten',
            'Institutional'                                         =>  'Institutional',
            'Hospital'                                              =>  'Hospital',
            'Community Building & Religious Institute'              =>  'Community Building & Religious Institute',
            'Office'                                                =>  'Office',
            'Market/Shop'                                           =>  'Market/Shop',
            'Industries, Warehouse, Hazardous use Buildings & Misc' =>  'Industries, Warehouse, Hazardous use Buildings & Misc'
        ];

        $project_category = [
            'Platinum'                                              =>  'Platinum',
            'Gold'                                                  =>  'Gold',
            'Silver'                                                =>  'Silver',
        ];

        $source = Source::pluck('name', 'id');

        $districts = [];
        $thanas = [];
        $mouzas = [];
        $divisions = Division::pluck('name', 'id');
        return view('bd.lead-generation.create', compact('thanas', 'districts', 'divisions', 'formType', 'land_under', 'lead_stage', 'source', 'category', 'project_category', 'mouzas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdLeadGenerationRequest $request)
    {

        try {
            $bd_lead_generation_data                = $request->only(
                'land_under',
                'lead_stage',
                'category',
                'source_id',
                'land_size',
                'front_road_size',
                'land_location',
                'remarks',
                'division_id',
                'district_id',
                'thana_id',
                'surrendered_land',
                'proposed_front_road_size',
                'proposed_front_road_size',
                'project_category',
                'land_status',
                'basement',
                'mouza_id',
                'storey'
            );
            $bd_lead_generation_data['entry_by']    = auth()->id();
            $bd_lead_generation_data['status']      = "Pending";

            if ($request->hasFile('survey_report')) {
                $bd_lead_generation_data['survey_report'] = $request->file('survey_report')->store(self::STORE_PATH);
            }


            $bd_lead_generation_details = [];

            foreach ($request->name as $key => $data) {
                $bd_lead_generation_details[] = [
                    'name'              =>  $request->name[$key],
                    'mobile'            =>  $request->mobile[$key],
                    'mail'              =>  $request->mail[$key],
                    'present_address'   =>  $request->present_address[$key]
                ];
            }


            $bd_lead_sideroad = [];
            if ($request->side_road_size != null) {
                foreach ($request->side_road_size as $key => $data) {
                    $bd_lead_sideroad[] = [
                        'feet'              =>  $request->side_road_size[$key] ? $request->side_road_size[$key] : 0,
                    ];
                }
            }


            $bd_lead_generation_picture = [];
            if ($request->picture) {
                foreach ($request->picture as  $key => $data) {
                    $bd_lead_generation_picture[] = ['picture' =>  $data->store(self::STORE_PATH)];
                }
            }
            DB::transaction(function () use ($bd_lead_generation_data, $bd_lead_generation_details, $bd_lead_generation_picture, $bd_lead_sideroad, $request) {
                $bd_lead_generation = BdLeadGeneration::create($bd_lead_generation_data);
                $bd_lead_generation->BdLeadGenerationDetails()->createMany($bd_lead_generation_details);
                $bd_lead_generation->BdLeadGenerationPictures()->createMany($bd_lead_generation_picture);
                if ($request->side_road_size != null) {
                    $bd_lead_generation->BdLeadGenerationSideRoads()->createMany($bd_lead_sideroad);
                }
                // BdLeadGenerationSideRoads
            });

            return redirect()->route('bd_lead.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BdLeadGeneration $bd_lead)
    {
        return view('bd.lead-generation.show', compact('bd_lead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BdLeadGeneration $bd_lead)
    {
        $formType = "edit";
        $land_under = [
            'PWD'                           => 'PWD',
            'CDA'                           => 'CDA',
            'NHA'                           => 'NHA',
            'Nasirabad Properties LTD'      => 'Nasirabad Properties LTD',
            'Co-operative Housing Society'  => 'Co-operative Housing Society',
            'Private Land'                  => 'Private Land'
        ];
        $lead_stage = [
            'Primary Stage'         => 'Primary Stage',
            'Maturing Stage'        => 'Maturing Stage',
            'Finalizing Stage'      => 'Finalizing Stage',
            'Settled'               => 'Settled'
        ];
        $category = [
            'Residential Building'                                  =>  'Residential Building',
            'Residential Hotel'                                     =>  'Residential Hotel',
            'Residential cum Commercial'                            =>  'Residential cum Commercial',
            'Commercial'                                            =>  'Commercial',
            'School, College, University'                           =>  'School, College, University',
            'Primary School & Kinder Garten'                        =>  'Primary School & Kinder Garten',
            'Institutional'                                         =>  'Institutional',
            'Hospital'                                              =>  'Hospital',
            'Community Building & Religious Institute'              =>  'Community Building & Religious Institute',
            'Office'                                                =>  'Office',
            'Market/Shop'                                           =>  'Market/Shop',
            'Industries, Warehouse, Hazardous use Buildings & Misc' =>  'Industries, Warehouse, Hazardous use Buildings & Misc'
        ];


        $project_category = [
            'Platinum'                                              =>  'Platinum',
            'Gold'                                                  =>  'Gold',
            'Silver'                                                =>  'Silver',
        ];


        $source = Source::pluck('name', 'id');

        $districts = District::where('division_id', $bd_lead->division_id)->pluck('name', 'id');
        $divisions = Division::pluck('name', 'id');
        $thanas = Thana::where('district_id', $bd_lead->district_id)->pluck('name', 'id');
        $mouzas = Mouza::where('thana_id', $bd_lead->thana_id)->pluck('name', 'id');
        return view('bd.lead-generation.create', compact('districts', 'divisions', 'thanas', 'formType', 'land_under', 'lead_stage', 'bd_lead', 'source', 'category', 'project_category', 'mouzas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdLeadGenerationRequest $request, BdLeadGeneration $bd_lead)
    {
        try {
            $bd_lead_generation_data                = $request->only('land_under', 'lead_stage', 'category', 'source_id', 'land_size', 'front_road_size',  'land_location', 'remarks', 'survey_report', 'division_id', 'district_id', 'thana_id', 'mouza_id', 'surrendered_land', 'proposed_front_road_size', 'proposed_front_road_size', 'project_category', 'land_status', 'basement', 'storey');
            $bd_lead_generation_data['entry_by']    = auth()->id();
            $bd_lead_generation_data['status']      = "Pending";

            if ($request->hasFile('survey_report')) {
                file_exists(asset($bd_lead->survey_report)) && $bd_lead->survey_report ? unlink($bd_lead->survey_report) : null;
                $bd_lead_generation_data['survey_report'] = $request->file('survey_report')->store('bdLead');
            }

            $bd_lead_generation_details = array();
            foreach ($request->name as  $key => $data) {

                $bd_lead_generation_details[] = [
                    'name'              =>  $request->name[$key],
                    'mobile'            =>  $request->mobile[$key],
                    'mail'              =>  $request->mail[$key],
                    'present_address'   =>  $request->present_address[$key]
                ];
            }
            $bd_lead_generation_picture = array();
            $deleted_images = [];
            if ($request->imgname) {
                foreach ($request->imgname as  $key => $data) {
                    $prev_pic = BdLeadGenerationPicture::where('bd_lead_generation_id', $bd_lead->id)->where('picture', $request->imgname[$key])->get();
                    if (count($prev_pic) > 0) {
                        $bd_lead_generation_picture[] = ['picture' => $request->imgname[$key]];
                    } else {
                        $bd_lead_generation_picture[] = ['picture' =>  $request->picture[$key]->store(self::STORE_PATH)];
                    }
                }
                $array1 = BdLeadGenerationPicture::where('bd_lead_generation_id', $bd_lead->id)->pluck('picture')->toArray();
                $deleted_images = array_diff($array1, $request->imgname);
            }

            $bd_lead_sideroad = [];
            if ($request->side_road_size != null) {
                foreach ($request->side_road_size as $key => $data) {
                    $bd_lead_sideroad[] = [
                        'feet'              =>  $request->side_road_size[$key] ? $request->side_road_size[$key] : 0,
                    ];
                }
            }
            DB::transaction(function () use ($bd_lead_generation_data, $bd_lead_generation_details, $bd_lead, $bd_lead_generation_picture, $deleted_images, $bd_lead_sideroad, $request) {
                if (count($deleted_images) > 0) {
                    foreach ($deleted_images as $deleted_image) {
                        file_exists(asset($deleted_image)) ? unlink($bd_lead->survey_report) : null;
                    }
                }
                $bd_lead->update($bd_lead_generation_data);
                $bd_lead->BdLeadGenerationDetails()->delete();
                $bd_lead->BdLeadGenerationDetails()->createMany($bd_lead_generation_details);
                $bd_lead->BdLeadGenerationPictures()->delete();
                $bd_lead->BdLeadGenerationPictures()->createMany($bd_lead_generation_picture);
                $bd_lead->BdLeadGenerationSideRoads()->delete();
                if ($request->side_road_size != null) {
                    $bd_lead->BdLeadGenerationSideRoads()->createMany($bd_lead_sideroad);
                }
            });

            return redirect()->route('bd_lead.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BdLeadGeneration $bd_lead)
    {
        try {
            $bd_lead->delete();
            return redirect()->route('bd_lead.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('bd_lead.index')->withErrors($e->getMessage());
        }
    }


    public function ShowFile($id)
    {
        $bdLeadGeneration = BdLeadGeneration::findOrFail(Crypt::decryptString($id));
        if (Storage::exists($bdLeadGeneration->survey_report)) {
            $FilePath = $bdLeadGeneration->survey_report;
            return response()->file(Storage::path($FilePath));
        } else {
            return redirect()->back()->withErrors('There is No attachment available');
        }
    }

    public function attachmentShowFile($id)
    {
        $BdLeadGenerationPicture = BdLeadGenerationPicture::findOrFail(Crypt::decryptString($id));
        if (Storage::exists($BdLeadGenerationPicture->picture)) {
            $FilePath = $BdLeadGenerationPicture->picture;
            return response()->file(Storage::path($FilePath));
        } else {
            return redirect()->back()->withErrors('There is No attachment available');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function followup($id)
    {
        $bd_lead = BdLeadGeneration::where('id', $id)->first();
        $followup_data = BdleadFollowUp::where('bd_lead_generation_id', $id)->get();
        return view('bd.lead-generation.followup', compact('bd_lead', 'followup_data'));
    }


    public function followupStore(BdLeadFollowupRequest $request, $id)
    {
        try {
            $bd_lead_followup                           = $request->only('remarks');
            $bd_lead_followup['bd_lead_generation_id']  = $id;
            $bd_lead_followup['followup_by']            = auth()->id();
            BdleadFollowUp::create($bd_lead_followup);
            return redirect()->route('bd_lead.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('bd_lead.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
