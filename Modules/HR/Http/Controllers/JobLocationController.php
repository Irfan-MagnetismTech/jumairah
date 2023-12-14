<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Line;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\JobLocation;

class JobLocationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('job-location-show');
        $jobLocations = JobLocation::where('com_id', auth()->user()->com_id)->latest()->get();
        return view('hr::job-location.index', compact('jobLocations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('job-location-create');
        $formType = 'create';
        return view('hr::job-location.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            $this->authorize('job-location-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                JobLocation::create($input);
            });

            return redirect()->route('job-locations.index')->with('message', 'Location created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('job-locations.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('job-location-edit');
        $formType = 'edit';
        $jobLocation = JobLocation::where('com_id', auth()->user()->com_id)->find($id);
        return view('hr::job-location.create', compact('formType', 'jobLocation'));
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
            $this->authorize('job-location-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                JobLocation::where('com_id', auth()->user()->com_id)->find($id)->update($input);
            });

            return redirect()->route('job-locations.index')->with('message', 'Job Location updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('job-locations.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('job-location-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $jobLocation = JobLocation::with('employees')->where('com_id', auth()->user()->com_id)->find($id);
                if ($jobLocation->employees->count() === 0) {
                    $jobLocation->delete();
                    $message = ['message' => 'Job location deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });

            return redirect()->route('job-locations.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('job-locations.index')->withErrors($e->getMessage());
        }
    }
}
