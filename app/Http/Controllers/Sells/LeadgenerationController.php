<?php

namespace App\Http\Controllers\Sells;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeadgenerationRequest;
use App\Sells\Apartment;
use App\Sells\Followup;
use App\Sells\Leadgeneration;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class LeadgenerationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:leadgeneration-view|leadgeneration-create|leadgeneration-edit|leadgeneration-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:leadgeneration-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:leadgeneration-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:leadgeneration-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $reportType = request('reportType');
        $prospectName = request('prospect_name');
        $orderBy = request('order_by_date');
        $user = request('user_id');
        $lead_stage = request('lead_stage');
        $project = request('project');
        //        dd($project);
        $raw = Leadgeneration::query()->with('apartment.project', 'followups')
            ->where('lead_stage', '!=', 'D')
            ->where('is_sold', 0)
            ->when($prospectName != null, function ($query) use ($prospectName) {
                $query->where('name', 'LIKE', '%' . $prospectName . '%');
            })
            ->when($orderBy != null, function ($query) use ($orderBy) {
                $query->orderBy('lead_date', $orderBy);
            })
            ->when($user != null, function ($query) use ($user) {
                $query->where('created_by', $user);
            })
            ->when($lead_stage != null, function ($query) use ($lead_stage) {
                $query->where('lead_stage', $lead_stage);
            })
            ->when($project != null, function ($query) use ($project) {
                $query->whereRelation('apartment', 'project_id', $project);
            })
            ->when($reportType == 'pdf', function ($query) use ($project) {
                $query->orderBy('lead_stage');
            })
            ->latest();
        $user = Auth::user();

        if ($user->hasAnyRole(['super-admin', 'Sales-HOD', 'admin', 'manager', 'authority'])) {
            $leadgenerations = $raw->get();
        } elseif ($user->head) {
            $teamMembers = $user->head->members->pluck('member_id', 'member_id')->toArray();
            array_push($teamMembers, auth()->id());
            $leadgenerations = $raw
                ->whereIn('created_by', $teamMembers)
                ->get();
        } else {
            $leadgenerations = $raw->where('created_by', auth()->id())->get();
        }

        if ($reportType == 'pdf') {
            // $leadgenerations->orderBy('lead_');
            return PDF::loadview('sales.leadgenerations.leadgenerationpdf', compact('leadgenerations'))
                // ->setPaper(array(0,0,612,1200), 'landscape')
                ->stream('leadgeneration.pdf');
        } else {
            return view('sales.leadgenerations.index', compact('leadgenerations'));
        }
    }

    public function deadList()
    {
        $raw = Leadgeneration::query()->with('apartment.project', 'followups')
            ->where('lead_stage', 'D')->where('is_sold', 0)->latest();
        $user = Auth::user();

        if ($user->hasAnyRole(['super-admin', 'Sales-HOD', 'admin', 'manager', 'authority'])) {
            $leadgenerations = $raw->get();
        } elseif ($user->head) {
            $teamMembers = $user->head->members->pluck('member_id', 'member_id')->toArray();
            array_push($teamMembers, auth()->id());
            $leadgenerations = $raw->whereIn('created_by', $teamMembers)->get();
        } else {
            $leadgenerations = $raw->whereCreatedBy(auth()->id())->get();
        }
        //        dd($raw);
        return view('sales.leadgenerations.index', compact('leadgenerations'));
    }

    public function create()
    {
        $codes = Country::pluck('phonecode', 'phonecode');
        $formType = 'create';
        $lead_stages = ['A' => 'Priority', 'B' => 'Negotiate', 'C' => 'Lead', 'D' => 'Closed Lead'];
        $apartments = [];
        return view('sales.leadgenerations.create', compact('formType', 'codes', 'lead_stages', 'apartments'));
    }

    public function store(LeadgenerationRequest $request)
    {
        try {
            $data = $request->except('business_card', 'attachment', 'project_name', 'project_id', 'created_by', 'date', 'next_followup_date', 'time_from', 'time_till', 'activity_type', 'reason', 'feedback');
            $followupData = $request->only('date', 'next_followup_date', 'time_from', 'time_till', 'activity_type', 'reason', 'feedback', 'remarks');

            $data['business_card'] = $request->hasFile('business_card') ? $request->file('business_card')->store('lead') : null;
            $data['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('lead') : null;
            $data['lead_date'] = date('d-m-Y', strtotime(now()));
            $data['created_by'] = auth()->id();

            $lead = Leadgeneration::create($data);
            $followupData['leadgeneration_id'] = $lead->id;
            $followupData['user_id'] = auth()->user()->id;
            $followup = Followup::create($followupData);

            return redirect()->route('leadgenerations.index')->with('message', 'Data has been inserted successfully');
            //            return redirect()->route('leadgenerations.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Leadgeneration $leadgeneration)
    {
        return view('sales/leadgenerations.show', compact('leadgeneration'));
    }

    public function edit(Leadgeneration $leadgeneration)
    {
        $formType = 'edit';
        $codes = Country::pluck('phonecode', 'phonecode');
        $lead_stages = ['A' => 'Priority', 'B' => 'Negotiate', 'C' => 'Lead', 'D' => 'Closed Lead'];
        $apartments = Apartment::where('project_id', $leadgeneration->apartment->project->id)->pluck('name', 'id');
        $follow_up = $leadgeneration->followups->first();
        return view('sales.leadgenerations.create', compact('codes', 'formType', 'lead_stages', 'apartments', 'leadgeneration', 'follow_up'));
    }

    public function update(LeadgenerationRequest $request, Leadgeneration $leadgeneration)
    {
        try {
            $data = $request->except('business_card', 'attachment', 'project_name', 'project_id');
            if ($request->hasFile('business_card')) {
                file_exists(asset($leadgeneration->business_card)) && $leadgeneration->business_card ? unlink($leadgeneration->business_card) : null;
                $data['business_card'] = $request->file('business_card')->store('lead');
            }

            if ($request->hasFile('attachment')) {
                file_exists(asset($leadgeneration->attachment)) && $leadgeneration->attachment ? unlink($leadgeneration->attachment) : null;
                $data['attachment'] = $request->file('attachment')->store('lead');
            }
            $leadgeneration->update($data);
            return redirect()->route('leadgenerations.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Leadgeneration $leadgeneration)
    {
        try {
            //            if($leadgeneration->followups->isNotEmpty()){
            //                return back()->withErrors(["There are some Followup record those belongs this Lead. Please remove them first."]);
            //            }
            if (!empty($leadgeneration->client)) {
                return back()->withErrors(["This lead already bought an apartment. Please remove the sell record first."]);
            }
            $leadgeneration->delete();
            return redirect()->route('leadgenerations.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function noactivity()
    {
        $check_days = request()->check_days ?? 90;
        $raw = Leadgeneration::with('apartment.project', 'lastFollowup')
            ->where('lead_stage', '!=', 'D')
            ->where('is_sold', 0)
            ->when(request()->project_id, function ($q) {
                $q->whereHas('apartment.project', function ($q) {
                    $q->whereId(request()->project_id);
                });
            })
            ->whereHas('lastFollowup')->latest()->get()->map(function ($item) use ($check_days) {
                if (Carbon::parse($item->lastFollowup->date) < now()->subDays($check_days)) {
                    return $item;
                }
            })->filter();
        //        dd($raw);
        $user = Auth::user();

        if ($user->hasAnyRole(['super-admin', 'Sales-HOD', 'admin', 'manager', 'authority'])) {
            $leadgenerations = $raw->filter();
        } elseif ($user->head) {
            $members = implode(',', $user->head->members()->pluck('member_id', 'member_id')->toArray());
            $leadgenerations = $raw
                ->whereIn('created_by', [$members, auth()->id()])
                ->filter();
            //            dd($leadgenerations);
        } else {
            $leadgenerations = $raw->where('created_by', auth()->id())->filter();
        }
        return view('sales.leadgenerations.noactivity', compact('leadgenerations'));
    }

    public function leadTransfer(Request $request)
    {
        try {
            $lead = Leadgeneration::where('id', $request->lead_id)->first();
            $lead->update(['created_by' => $request->transfer_id]);
            return redirect()->route('leadgenerations.index')->with('message', 'Lead has been Transfered successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function contactMessage($contact, $code)
    {
        $country = Country::where('phonecode', $code)->first();
        $data = Leadgeneration::where('country_code', $code)->where('contact', $contact)
            ->orWhere('contact_alternate', $contact)
            ->orWhere('contact_alternate_three', $contact)
            ->orWhere('spouse_contact', $contact)
            ->first();

        $length = strlen($contact);

        // dd($length, $country->number_length);

        if ($length != $country->number_length) {
            $message = " Invalid Phone Number";
        } else if (!empty($data)) {
            $date = date('d-m-Y', strtotime($data->created_at));
            $name = $data->createdBy->name;
            $designation = $data->createdBy->designation->name ?? null;
            $last_followup = $data->lastFollowup->date ?? null;
            $lead_stage =  $data->lead_stage ?? null;
            $message = " $name - $designation is Already Add this in $date F.Date: $last_followup Lead Stage: $lead_stage";
        } else {
            $message = "";
        }
        return response()->json($message);
    }

    public function search(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect('leadgenerations');
        }

        $reportType = $request->reportType;

        //        dd($request->all());
        $raw = Leadgeneration::query()->with('apartment.project', 'followups')->where('is_sold', 0)->latest();
        $user = Auth::user();
        //dd($request->all());
        if ($user->hasAnyRole(['super-admin', 'admin', 'Sales-HOD', 'authority'])) {
            if ($request->project != '') {
                $raw = Leadgeneration::with('apartment')->where('is_sold', 0)->whereHas('apartment', function ($query) use ($request) {
                    $query->where('project_id', $request->project);
                })->where('name', 'LIKE', $request->prospect_name);
            } else {
                $raw = $raw->where('name', 'LIKE', '%' . $request->prospect_name . '%');
            }
            // dd($raw->get());
            if ($request->user_id != '') {
                $raw = $raw->where('created_by', $request->user_id);
            }
            // dd($raw->get());
            if ($request->lead_stage != '') {
                $raw = $raw->where('lead_stage', $request->lead_stage);
            }

            if ($request->order_by_date == 'asc') {
                $leadgenerations = $raw->orderBy('lead_date', 'asc')->get();
            } else {
                $leadgenerations = $raw->orderBy('lead_date', 'asc')->get();
            }
        } elseif ($user->head) {
            $leadgenerations = $raw
                ->whereCreatedBy(auth()->id())
                ->orWhereIn('created_by', [$user->head->members->pluck('member_id')])
                ->orderBy('lead_date', 'asc')
                ->get();
        } else {
            $leadgenerations = $raw->whereCreatedBy(auth()->id())->get();
        }
        if ($reportType == 'pdf') {
            return PDF::loadview('sales.leadgenerations.leadgenerationpdf', compact('leadgenerations'))
                // ->setPaper(array(0,0,612,1200), 'landscape')
                ->stream('leadgeneration.pdf');
        } else {
            return view('sales.leadgenerations.index', compact('leadgenerations'));
        }
    }


    public function projectWiseLeadReport(Request $request)
    {
        $user = Auth::user();
        if ($user->hasAnyRole(['super-admin', 'Sales-HOD', 'admin', 'manager', 'authority'])) {
            $leads = Leadgeneration::with('apartment')->get();
        } elseif ($user->head) {
            $teamMembers = $user->head->members->pluck('member_id', 'member_id')->toArray();
            array_push($teamMembers, auth()->id());
            $leads = Leadgeneration::with('apartment')->whereIn('created_by', $teamMembers)->get();
        } else {
            $leads = Leadgeneration::with('apartment')->whereCreatedBy(auth()->id())->get();
        }

        $projectleads = $leads->groupBy('apartment.project_id')->map(function ($projectLead) {
            $leadInfo['projectName'] = $projectLead->first()->apartment->project->name;
            $leadInfo['projectLocation'] = $projectLead->first()->apartment->project->location;
            $leadInfo['projectTotalLeads'] = $projectLead->count();
            $leadInfo['leadStages'] = $projectLead->groupBy('lead_stage')->map(function ($q) {
                return $q->count();
            });
            return $leadInfo;
        });

        if ($request->reportType == 'pdf') {
            return PDF::loadview('sales.sales-report.project-wise-lead-reportpdf', compact('request', 'projectleads'))
                ->setPaper('a4', 'landscape')
                ->stream('project-wise-lead-report.pdf');
        } else {
            return view('sales.sales-report.project-wise-lead-report', compact('request', 'projectleads'));
        }
    }
}
