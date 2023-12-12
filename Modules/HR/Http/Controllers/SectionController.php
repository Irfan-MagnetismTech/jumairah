<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Section;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Department;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\SoftwareSettings\Entities\CompanyInfo;

class SectionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('section-show');
        $sections = Section::with('department')->where('com_id',auth()->user()->com_id)->latest()->get();
        return view('hr::section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('section-create');
        $formType = "create";
        $depertments =  Department::where('com_id', auth()->user()->com_id)->orderBy('name')->pluck('name', 'id');
        return view('hr::section.create',compact('formType','depertments'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('section-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Section::create($input);
            });

            return redirect()->route('sections.index')->with('message', 'Section information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('sections.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('section-edit');
        $formType = "edit";
        $depertments =  Department::where('com_id', auth()->user()->com_id)->orderBy('name')->pluck('name', 'id');
        $section = Section::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
        return view('hr::section.create',compact('formType','depertments','section'));
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
            $this->authorize('section-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request,$id) {
                Section::where('id',$id)->where('com_id',auth()->user()->com_id)->first()->update($input);
            });

            return redirect()->route('sections.index')->with('message', 'Section information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('sections.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('section-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $section = Section::where('id',$id)->where('com_id',auth()->user()->com_id)->first();
                // dd($section);
                if ($section->subsections->count() === 0 && $section->employees->count() === 0) {
                    $section->delete();
                    $message = ['message'=>'Section deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('sections.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('sections.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
