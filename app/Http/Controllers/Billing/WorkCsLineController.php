<?php

namespace App\Http\Controllers\Billing;

use App\Billing\WorkCsLine;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkCsLineRequest;
use App\Http\Requests\UpdateWorkCsLineRequest;

class WorkCsLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWorkCsLineRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkCsLineRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Billing\WorkCsLine  $workCsLine
     * @return \Illuminate\Http\Response
     */
    public function show(WorkCsLine $workCsLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing\WorkCsLine  $workCsLine
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkCsLine $workCsLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkCsLineRequest  $request
     * @param  \App\Billing\WorkCsLine  $workCsLine
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkCsLineRequest $request, WorkCsLine $workCsLine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Billing\WorkCsLine  $workCsLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkCsLine $workCsLine)
    {
        //
    }
}
