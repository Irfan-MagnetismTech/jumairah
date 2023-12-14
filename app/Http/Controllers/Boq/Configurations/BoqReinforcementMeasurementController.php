<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqReinforcementMeasurement;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqReinforcementMeasurementRequest;
use App\Procurement\Unit;
use App\Project;
use Illuminate\Http\Request;

class BoqReinforcementMeasurementController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:boq-civil', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * @param Project $project
     */
    public function index(Project $project)
    {
        $measurements = BoqReinforcementMeasurement::paginate(10);

        return view('boq.departments.civil.configurations.reinforcement-measurement.index', compact('measurements', 'project'));
    }

    /**
     * @param Project $project
     */
    public function create(Project $project)
    {
        $units = Unit::all();

        return view('boq.departments.civil.configurations.reinforcement-measurement.create', compact('units', 'project'));
    }

    /**
     * @param BoqReinforcementMeasurementRequest $request
     * @param Project $project
     */
    public function store(BoqReinforcementMeasurementRequest $request, Project $project)
    {
        try {
            BoqReinforcementMeasurement::create($request->all());

            return redirect()->route('boq.project.departments.civil.configurations.reinforcement-measurement.index', $project)
                ->withMessage('Measurement created successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * @param Project $project
     * @param BoqReinforcementMeasurement $reinforcementMeasurement
     */
    public function edit(Project $project, BoqReinforcementMeasurement $reinforcementMeasurement)
    {
        $units = Unit::all();

        return view('boq.departments.civil.configurations.reinforcement-measurement.edit', compact('units', 'reinforcementMeasurement', 'project'));
    }

    /**
     * @param Project $project
     * @param BoqReinforcementMeasurement $reinforcementMeasurement
     * @param BoqReinforcementMeasurementRequest $request
     */
    public function update(Project $project, BoqReinforcementMeasurement $reinforcementMeasurement, BoqReinforcementMeasurementRequest $request)
    {
        try {
            $reinforcementMeasurement->update($request->all());

            return redirect()->route('boq.project.departments.civil.configurations.reinforcement-measurement.index', $project)
                ->withMessage('Measurement updated successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * @param Project $project
     * @param BoqReinforcementMeasurement $reinforcementMeasurement
     */
    public function destroy(Project $project, BoqReinforcementMeasurement $reinforcementMeasurement)
    {
        try {
            $reinforcementMeasurement->delete();

            return redirect()->route('boq.project.departments.civil.configurations.reinforcement-measurement.index', $project)
                ->withMessage('Measurement deleted successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }
}
