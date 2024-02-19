<?php

namespace App\Http\Controllers\Boq\Projects\Configurations;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Boq\Projects\BoqFloorProject;
use Illuminate\Http\RedirectResponse;
use App\Boq\Departments\Civil\BoqFloorProjectApproval;

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

        $approval = BoqFloorProjectApproval::where('project_id', $project->id)->first() ? 1 : 0;

        return view('boq.projects.configurations.create-area', compact('project', 'boq_floor_projects', 'approval'));
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

    public function floorApproval(Project $project)
    {
        $approval = BoqFloorProjectApproval::where('project_id', $project->id)->first();

        if (is_null($approval)) {
            BoqFloorProjectApproval::create([
               'project_id' => $project->id,
                'status'    => 1
            ]);

            return redirect()->route('boq.project.configurations.areas.index', ['project' => $project])->withMessage('Project has been  approved!');
        } else {
            return redirect()->route('boq.project.configurations.areas.index', ['project' => $project])->withMessage('Project already   approved!');
        }
    }
}
