<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\District;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\PoliceStation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PoliceStationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('police-station-show');
        $policeStations = PoliceStation::with('districts')->latest()->get();
        return view('hr::police-station.index', compact('policeStations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('police-station-create');
        $formType = 'create';
        $districts = District::orderBy('name')->pluck('name', 'id');
        return view('hr::police-station.create', compact('formType', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('police-station-create');
            $input = $request->all();
            DB::transaction(function () use ($input) {
                PoliceStation::create($input);
            });
            return redirect()->route('police-stations.index')->with('message', 'Police Station created successfully.');
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
        $this->authorize('police-station-edit');
        $formType = 'edit';
        $policeStation = PoliceStation::findOrFail($id);
        $districts = District::orderBy('name')->pluck('name', 'id');
        return view('hr::police-station.create', compact('formType', 'policeStation', 'districts'));
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
            $this->authorize('police-station-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                PoliceStation::findOrFail($id)->update($input);
            });
            return redirect()->route('police-stations.index')->with('message', 'Police Station updated successfully.');
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
            $this->authorize('police-station-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $policestation = PoliceStation::with('postoffices')->findOrFail($id);
                // dd($policestation);
                if ($policestation->postoffices->count() === 0) {
                    $policestation->delete();
                    $message = ['message'=>'Police Station deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('police-stations.index')->with($message);
            // DB::transaction(function () use ($id) {
            //     PoliceStation::findOrFail($id)->delete();
            // });
            // return redirect()->route('police-stations.index')->with('message', 'Police Station deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function fetchPoliceStation(Request $request)
    {
        $this->authorize('police-station-show');
        $districtId = $request->input('district_id');
        $key = $request->input('key');
        // dd($key);
        $policeStations = PoliceStation::where('district_id', $districtId)->get();

        // Return the HTML for the Division dropdown options
        if (count($policeStations)>0) {
            $html = '<option value="">Select a division</option>';
            foreach ($policeStations as $policeStation) {
                $html .= '<option value="' . $policeStation->id . '" ' . (($key == $policeStation->id) ? "selected" : "") . '>' . $policeStation->name . '</option>';
            }
        }
        else{
            $html = '<option value="">No Police Stations</option>';
        }
        return $html;
    }
}
