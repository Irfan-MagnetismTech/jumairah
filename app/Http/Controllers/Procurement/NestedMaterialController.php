<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\NestedMaterialRequest;
use App\Procurement\NestedMaterial;
use App\Procurement\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NestedMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:nestedmaterial-view|nestedmaterial-create|nestedmaterial-edit|nestedmaterial-delete', ['only' => ['index','show']]);
        $this->middleware('permission:nestedmaterial-create', ['only' => ['create','store']]);
        $this->middleware('permission:nestedmaterial-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:nestedmaterial-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material_id = request()->material_id;
        if (request()->material_id) {

            $material_details = NestedMaterial::whereAncestorOrSelf($material_id)->get()->toTree();
            $material_depth = NestedMaterial::withDepth()->find(request()->material_id);

        } else {

            $materials = NestedMaterial::with('unit','account')->get();
            $material_details =     $materials->toTree();
            $material_depth = null;
        }
        return view('procurement.nestedmaterials.index', compact( 'material_details', 'material_depth'));
    }

    public function materialList()
    {
        $materials = NestedMaterial::with('descendants','ancestors')->withDepth()->having('depth', '=', 0)->whereNull('parent_id')
            ->paginate(1);
        return view('procurement.nestedmaterials.materialList', compact('materials'))
            ->with('i',(request()->input('page', 1) -1) * 1)
            ;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::where('balance_and_income_line_id',11)->where('parent_account_id', '!=',null)->pluck('account_name','id');
        $formType = "create";
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
        $units = Unit::orderBy('id')->pluck('name', 'id');
        return view('procurement.nestedmaterials.create', compact('formType', 'accounts','leyer1NestedMaterial', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NestedMaterialRequest $request)
    {
        try{
            $material_data = $request->only('name','parent_id','unit_id', 'account_id', 'material_status');

            $parent_id = array_filter($request->parent_id, 'strlen');
            $material_data['parent_id'] = end($parent_id) ? end($parent_id) : NULL;
            DB::transaction(function() use($material_data){
                $material = NestedMaterial::create($material_data);
                if ($material->account_id){
                    $material->descendants()->update(['account_id'=> $material->account_id]);
                }
            });

            return redirect()->route('nestedmaterials.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(NestedMaterial $nestedmaterial)
    {
        $material = NestedMaterial::where('id', $nestedmaterial->id)->firstOrFail();
        return view('procurement.nestedmaterials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(NestedMaterial $nestedmaterial)
    {

        $layer4 = null;
        $layer3 = null;
        $layer2 = null;
        $layer1 = null;
        $leyer2NestedMaterial = [];
        $leyer3NestedMaterial = [];
        if($nestedmaterial->getParentId() == null){
            $layer1 = $nestedmaterial->id;
        }elseif($nestedmaterial->parent->getParentId() == null){
            $layer1 = $nestedmaterial->parent->id;
            $layer2 = $nestedmaterial->id;
        }elseif($nestedmaterial->parent->parent->getParentId() == null){

            $layer1 = $nestedmaterial->parent->parent->id;
            $layer2 = $nestedmaterial->parent->id;
            $leyer2NestedMaterial = NestedMaterial::where('parent_id',$layer1)->orderBy('id')->pluck('name', 'id');
        }elseif($nestedmaterial->parent->parent->parent->getParentId() == null){

            $layer1 = $nestedmaterial->parent->parent->parent->id;
            $layer2 = $nestedmaterial->parent->parent->id;
            $layer3 = $nestedmaterial->parent->id;
            $layer4 = $nestedmaterial->id;
            $leyer2NestedMaterial = NestedMaterial::where('parent_id',$layer1)->orderBy('id')->pluck('name', 'id');
            $leyer3NestedMaterial = NestedMaterial::where('parent_id',$layer2)->orderBy('id')->pluck('name', 'id');
        }
        $leyer1NestedMaterial = NestedMaterial::where('parent_id',null)->orderBy('id')->pluck('name', 'id');

        $accounts = Account::where('balance_and_income_line_id',11)->pluck('account_name','id');
        $formType = "edit";
        $units = Unit::orderBy('name')->pluck('name', 'id');
        $materials = NestedMaterial::orderBy('name')->pluck('name', 'id');
        return view('procurement.nestedmaterials.create', compact('nestedmaterial', 'accounts','leyer1NestedMaterial','leyer2NestedMaterial','leyer3NestedMaterial','formType',  'units','layer1','layer2','layer3'));
    }

    public function update(Request $request, NestedMaterial $nestedmaterial)
    {
        try{
            $material_data = $request->only('name','parent_id','unit_id', 'material_status', 'account_id');
            $parent_id = array_filter($request->parent_id, 'strlen');
            $material_data['parent_id'] = end($parent_id) ? end($parent_id) : NULL;

            // dd($material_data);
            DB::transaction(function()use($nestedmaterial,$material_data){
                $nestedmaterial->update($material_data);
                if ($nestedmaterial->account_id){
                    $nestedmaterial->descendants()->update(['account_id'=> $nestedmaterial->account_id]);
                }
            });

            return redirect()->route('nestedmaterials.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('nestedmaterials.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NestedMaterial $nestedmaterial)
    {
        try{
            if($nestedmaterial->boqSupremeBudgets()->exists()){
                return redirect()->route('nestedmaterials.index')->with('message', 'Please delete BOQ budget first');
            }elseif($nestedmaterial->requisitionDetails()->exists()){
                return redirect()->route('nestedmaterials.index')->with('message', 'Please delete requisition first');
            }
            elseif($nestedmaterial->childs()->exists()){
                return redirect()->route('nestedmaterials.index')->with('message', 'Please delete Child Material first');
            }
            else{
                $nestedmaterial->delete();
                return redirect()->route('nestedmaterials.index')->with('message', 'Data has been deleted successfully');
            }
        }catch(QueryException $e){
            return redirect()->route('nestedmaterials.create')->withErrors($e->getMessage());
        }
    }

}
