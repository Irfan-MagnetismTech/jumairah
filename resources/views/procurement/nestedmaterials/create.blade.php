@extends('layouts.backend-layout')
@section('title', 'Materials')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Material
    @else
        Add Material
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('nestedmaterials') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if ($formType == 'edit')
        {!! Form::open([
            'url' => "nestedmaterials/$nestedmaterial->id",
            'method' => 'PUT',
            'encType' => 'multipart/form-data',
            'class' => 'custom-form',
        ]) !!}
    @else
        {!! Form::open([
            'url' => 'nestedmaterials',
            'method' => 'POST',
            'encType' => 'multipart/form-data',
            'class' => 'custom-form',
        ]) !!}
    @endif
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Material Name<span class="text-danger">*</span></label>
                {{ Form::text('name', old('name') ? old('name') : (!empty($nestedmaterial->name) ? $nestedmaterial->name : null), ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off', 'required', 'placeholder' => 'Material Name']) }}
            </div>
        </div>

        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parent_id0">1st layer</label>
                {{ Form::select(
                    'parent_id[]',
                    $leyer1NestedMaterial,
                    old('parent_id[0]') ? old('parent_id[0]') : (!empty($nestedmaterial->parent_id) ? $layer1 : null),
                    $formType == 'edit'
                        ? [
                            'class' => 'form-control material',
                            'id' => 'parent_id0',
                            'placeholder' => 'Select 1st layer material Name',
                            'autocomplete' => 'off',
                        ]
                        : [
                            'class' => 'form-control material',
                            'id' => 'parent_id0',
                            'placeholder' => 'Select 1st layer material Name',
                            'autocomplete' => 'off',
                        ],
                ) }}
            </div>
        </div>
        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parent_id1">2nd layer</label>
                {{ Form::select(
                    'parent_id[]',
                    !empty($nestedmaterial->parent_id) ? $leyer2NestedMaterial : [],
                    old('parent_id[1]') ? old('parent_id[1]') : (!empty($nestedmaterial->parent_id) ? $layer2 : null),
                    $formType == 'edit'
                        ? [
                            'class' => 'form-control material',
                            'id' => 'parent_id1',
                            'placeholder' => 'Select 2nd layer material Name',
                            'autocomplete' => 'off',
                        ]
                        : [
                            'class' => 'form-control material',
                            'id' => 'parent_id1',
                            'placeholder' => 'Select 2nd layer material Name',
                            'autocomplete' => 'off',
                        ],
                ) }}
            </div>
        </div>
        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parent_id2">3rd layer</span></label>
                {{ Form::select(
                    'parent_id[]',
                    !empty($nestedmaterial->parent_id) ? $leyer3NestedMaterial : [],
                    old('parent_id[2]') ? old('parent_id[2]') : (!empty($nestedmaterial->parent_id) ? $layer3 : null),
                    $formType == 'edit'
                        ? [
                            'class' => 'form-control material',
                            'id' => 'parent_id2',
                            'placeholder' => 'Select 3rd layer material Name',
                            'autocomplete' => 'off',
                        ]
                        : [
                            'class' => 'form-control material',
                            'id' => 'parent_id2',
                            'placeholder' => 'Select 3rd layer material Name',
                            'autocomplete' => 'off',
                        ],
                ) }}
            </div>
        </div>


        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="unit_id">Unit<span class="text-danger">*</span></label>
                {{ Form::select('unit_id', $units, old('unit_id') ? old('unit_id') : (!empty($nestedmaterial->unit_id) ? $nestedmaterial->unit_id : null), ['class' => 'form-control', 'id' => 'unit_id', 'placeholder' => 'Select Unit', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="account_id">Account Head<span class="text-danger">*</span></label>
                {{ Form::select('account_id', $accounts, old('account_id') ? old('account_id') : (!empty($nestedmaterial->account_id) ? $nestedmaterial->account_id : null), ['class' => 'form-control', 'id' => 'account_id', 'placeholder' => 'Select Account Head Name', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-12 col-xl-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon">Material Status<span class="text-danger">*</span></label>
                <input type="radio" id="Material" name="material_status" value="Material"
                    style="margin-left: 30px; margin-top: 8px"
                    {{ !empty($nestedmaterial) ? ($nestedmaterial->material_status == 'Material' ? 'checked' : null) : '' }}>
                <label style="margin-left: 5px; margin-top: 18px" for="Material">Material</label><br>

                <input type="radio" id="Fixed Asset" name="material_status" value="Fixed Asset"
                    style="margin-left: 30px; margin-top: 8px"
                    {{ !empty($nestedmaterial) ? ($nestedmaterial->material_status == 'Fixed Asset' ? 'checked' : null) : '' }}>
                <label style="margin-left: 5px; margin-top: 18px" for="Fixed Asset">Fixed Asset</label><br>
                <input type="radio" id="Scrap Material" name="material_status" value="Scrap Material"
                    style="margin-left: 30px; margin-top: 8px"
                    {{ !empty($nestedmaterial) ? ($nestedmaterial->material_status == 'Scrap Material' ? 'checked' : null) : '' }}>
                <label style="margin-left: 5px; margin-top: 18px" for="Scrap Material">Scrap Material</label><br>

                <!-- author showrav biswas -->

                <input type="radio" id="Work-Material" name="material_status" value="Work-Material"
                    style="margin-left: 30px; margin-top: 8px"
                    {{ !empty($nestedmaterial) ? ($nestedmaterial->material_status == 'Work-Material' ? 'checked' : null) : '' }}>
                <label style="margin-left: 5px; margin-top: 18px" for="Work Material">Work Material</label><br>

                <!-- author showrav biswas -->
            </div>
        </div>


    </div><!-- end row -->
    <hr class="bg-success">
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}



    <script></script>

@endsection



@section('script')
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";





        $(function() {
            $('.material').on('change', function() {
                var material_id = $(this).val();
                var selected_data = this;
                $.ajax({
                    url: "{{ url('scj/getChildMaterial') }}",
                    type: 'GET',
                    data: {
                        'material_id': material_id
                    },
                    success: function(data) {
                        $(selected_data).parent('div').parent('div').next('div').find(
                            '.material').html();
                        $(selected_data).parent('div').parent('div').next('div').find(
                            '.material').html(data);
                    }
                });
            })
        }) // Document.Ready
    </script>
@endsection
