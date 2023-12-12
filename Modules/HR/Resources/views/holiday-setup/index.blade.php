@extends('layouts.backend-layout')
@section('title', 'Holidy Setup')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Holiday Setup
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('holiday-create')
        <a href="{{ route('holidays.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    {{-- Total: {{ count($holiday) }} --}}
@endsection
@section('content')
    <style>
        input[type=search] {
            padding: .5rem .0rem !important;
        }
    </style>
    <div class="row">
        <div class="col-sm-8 col-md-8">
            <div class="dt-responsive table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Remark</th>
                            @canany(['holiday-edit', 'holiday-delete'])
                                <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#SL</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Remark</th>
                            @canany(['holiday-edit', 'holiday-delete'])
                                <th>Action</th>
                            @endcanany
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($holidays as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->date }}</td>
                                <td>{{ $data->type == 'h' ? 'Holiday' : 'Weekend' }}</td>
                                <td>{{ $data->remarks }}</td>
                                @canany(['holiday-edit', 'holiday-delete'])
                                    <td>
                                        <div class="icon-btn">
                                            <nobr>
                                                @can('holiday-edit')
                                                    <a href="{{ route('holidays.edit', $data->id) }}" data-toggle="tooltip"
                                                        title="Edit" class="btn btn-outline-warning"
                                                        onclick="edit({{ $data->id }})"><i class="fas fa-pen"></i></a>
                                                @endcan
                                                @can('holiday-delete')
                                                    <form action="{{ url("hr/holidays/$data->id") }}" method="POST"
                                                        data-toggle="tooltip" title="Delete" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </nobr>
                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @can('holiday-create')
            <div class="col-sm-4 col-md-4">
                @if ($formType == 'create')
                    {!! Form::open([
                        'url' => 'hr/holidays',
                        'method' => 'POST',
                        'class' => 'custom-form',
                        'files' => true,
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                @else
                    {!! Form::open([
                        'url' => "hr/holidays/$holiday->id",
                        'method' => 'PUT',
                        'class' => 'custom-form',
                        'files' => true,
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                                for="name">Date <span class="text-danger">*</span></label>
                            {{ Form::date('date', old('date') ? old('date') : (!empty($holiday->date) ? $holiday->date : null), [
                                'class' => 'form-control',
                                'id' => 'date',
                                'placeholder' => 'Enter date Here',
                                'required',
                            ]) }}
                            @error('date')
                                <p class="text-danger">{{ $errors->first('date') }}</p>
                            @enderror

                        </div>

                    </div>

                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                                for="type">Type <span class="text-danger">*</span></label>
                            {{ Form::select(
                                'type',
                                ['h' => 'Holiday', 'w' => 'Weekend'],
                                old('type') ? old('type') : (!empty($holiday->type) ? $holiday->type : null),
                                [
                                    'class' => 'form-control',
                                    'id' => 'type',
                                    'placeholder' => 'Select Type',
                                    'required',
                                ],
                            ) }}
                            @error('type')
                                <p class="text-danger">{{ $errors->first('type') }}</p>
                            @enderror

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                                for="remarks">Remarks <span class="text-danger">*</span></label>
                            {{ Form::text(
                                'remarks',
                                old('remarks') ? old('remarks') : (!empty($holiday->remarks) ? $holiday->remarks : null),
                                [
                                    'class' => 'form-control',
                                    'id' => 'remarks',
                                    'placeholder' => 'Enter remarks Here',
                                    'required',
                                ],
                            ) }}
                            @error('remarks')
                                <p class="text-danger">{{ $errors->first('remarks') }}</p>
                            @enderror

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2 ">
                        <div class="input-group input-group-sm ">
                            @if ($formType == 'create')
                                <button class="btn btn-success btn-round btn-block py-2">Save</button>
                            @else
                                <button class="btn btn-success btn-round btn-block py-2">Update</button>
                            @endif
                        </div>
                    </div>
                </div> <!-- end row -->

                {!! Form::close() !!}

            </div>
        @endcan

    </div>
@endsection

@section('script')

    <script></script>
@endsection
