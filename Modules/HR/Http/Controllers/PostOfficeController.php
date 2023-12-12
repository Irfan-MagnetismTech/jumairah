<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\District;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\PostOffice;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\PoliceStation;

class PostOfficeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('post-office-show');
        $postOffices = PostOffice::with('district','police_station')->latest()->get();
        return view('hr::post-office.index', compact('postOffices'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('post-office-create');
        $formType = 'create';
        $districts = District::orderBy('name')->pluck('name', 'id');
        $policeStations = PoliceStation::orderBy('name')->pluck('name', 'id');
        return view('hr::post-office.create', compact('formType', 'districts', 'policeStations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('post-office-create');
            $input = $request->all();
            DB::transaction(function () use ($input) {
                PostOffice::create($input);
            });
            return redirect()->route('post-offices.index')->with('message', 'Post Office created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('post-office-edit');
        $formType = 'edit';
        $postOffice = PostOffice::findOrFail($id);
        $districts = District::orderBy('name')->pluck('name', 'id');
        $policeStations = PoliceStation::orderBy('name')->pluck('name', 'id');
        return view('hr::post-office.create', compact('formType', 'postOffice', 'policeStations', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            $this->authorize('post-office-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                $postOffice = PostOffice::findOrFail($id);
                $postOffice->update($input);
            });
            return redirect()->route('post-offices.index')->with('message', 'Post Office updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $this->authorize('post-office-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $postOffice = PostOffice::with('employeeaddress')->findOrFail($id);
                // dd($postOffice);
                if ($postOffice->employeeaddress->count() === 0) {
                    $postOffice->delete();
                    $message = ['message'=>'Post Office deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('post-offices.index')->with($message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function fetchPostOffice(Request $request)
    {
        $this->authorize('post-office-show');
        $policeStationId = $request->input('police_station_id');
        $key = $request->input('key');

        $postOffices = PostOffice::where('police_station_id', $policeStationId)->get();

        // Return the HTML for the Division dropdown options
        if (count($postOffices)>0) {
            $html = '<option value="">Select a division</option>';
            foreach ($postOffices as $postOffice) {
                $html .= '<option value="' . $postOffice->id . '" ' . (($key == $postOffice->id) ? "selected" : "") . '>' . $postOffice->name . '</option>';
            }
        }
        else{
            $html = '<option value="">No Post Offices</option>';
        }
        return $html;
    }
}
