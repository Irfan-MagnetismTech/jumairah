<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqFloorType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqFloorTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoqFloorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floor_types = BoqFloorType::paginate(10);

        return view('boq.configurations.floortype.index', compact('floor_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $floor_types = BoqFloorType::orderBy('serial_no')->get();

        return view('boq.configurations.floortype.create', compact('floor_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqFloorTypeRequest $request)
    {
        try {
            DB::transaction(function () use ($request)
            {
                BoqFloorType::whereNotIn('name', $request->name)->delete();

                foreach ($request->name as $index => $floor_type_name)
                {
                    BoqFloorType::updateOrCreate(
                        ['name' => Str::lower($floor_type_name)],
                        [
                            'name'             => Str::lower($floor_type_name),
                            'has_buildup_area' => $request->has_buildup_area[$index],
                            'serial_no'        => $index + 1,
                        ]
                    );
                }
            });

            return redirect()->route('boq.configurations.floortype.create')
                ->withMessage('Floor type updated successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
