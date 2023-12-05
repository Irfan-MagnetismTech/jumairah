<?php

namespace App\Http\Controllers\Boq\Projects\Configurations;

use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BoqProjectAreaConfigController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-configuration-edit', ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project): View
    {
        $project->load('boqFloorProjects');
        $boq_floor_projects = BoqFloorProject::with('floor.floor_type')
            ->where('project_id', $project->id)
            ->get()
            ->sortBy(['floor.floor_type.serial_no', 'floor.id']);

        return view('boq.projects.configurations.create-area', compact('project', 'boq_floor_projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        try {
            foreach ($request->boq_floor_project_id as $index => $boq_floor_project_id)
            {
                BoqFloorProject::where('boq_floor_project_id', $boq_floor_project_id)->update(
                    [
                        'boq_floor_project_id' => $boq_floor_project_id,
                        'area'                 => $request->area[$index],
                    ]
                );
            }

            return redirect()->route('boq.project.configurations.areas.index', ['project' => $project])
                ->withMessage('Area updated successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withError($e->getMessage());
        }
    }
}
