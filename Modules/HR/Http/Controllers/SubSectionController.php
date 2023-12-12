<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Section;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\SubSection;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class SubSectionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('sub-section-show');
        $subSections = SubSection::where('com_id', auth()->user()->com_id)->latest()->get();
        return view('hr::sub_section.index', compact('subSections'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('sub-section-create');
        $formType = "create";
        $sections =  Section::where('com_id', auth()->user()->com_id)->orderBy('name')->pluck('name', 'id');
        return view('hr::sub_section.create',compact('formType','sections'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('sub-section-create');
            $input = $request->all();
            SubSection::create($input);
            return redirect()->route('sub-sections.index')->with('message', 'Sub Section information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('sub-sections.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('sub-section-edit');
        $formType = "edit";
        $subSection = SubSection::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
        $sections =  Section::where('com_id', auth()->user()->com_id)->orderBy('name')->pluck('name', 'id');
        return view('hr::sub_section.create',compact('formType','subSection','sections'));
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
            $this->authorize('sub-section-edit');
            $input = $request->all();
            $subSection = SubSection::where('com_id', auth()->user()->com_id)->where('id',$id)->first();;
            $subSection->update($input);
            return redirect()->route('sub-sections.index')->with('message', 'Sub Section information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('sub-sections.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('sub-section-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $subSection = SubSection::with('employees')->where('com_id', auth()->user()->com_id)->where('id',$id)->first();;
                // dd($subSection);
                if ($subSection->employees->count() === 0) {
                    $subSection->delete();
                    $message = ['message'=>'Sub Section deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('sub-sections.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('sub-sections.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
