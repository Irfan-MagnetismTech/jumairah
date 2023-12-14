@extends('layouts.backend-layout')
@section('title', 'Lead Generation')

@section('breadcrumb-title')
    {{ empty($bd_lead) ? 'New Lead Generation' : 'Edit Lead Generation' }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bd_lead.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection


@section('content-grid', null)

@section('content')
    {!! Form::open(array('url' => "followupStore/$bd_lead->id",'method' => 'POST', 'class'=>'custom-form')) !!}

    <div class="table-responsive">
        <table id="purchaseTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>L/O Name</th>
                    <th>Land Size</th>
                    <th>Land Location</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> 
                        @foreach($bd_lead->BdLeadGenerationDetails as $row)
                            {{ $row->name }},
                        @endforeach
                    </td>
                    <td> {{ $bd_lead->land_size }} </td>
                    <td> {{ $bd_lead->land_location }} </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks"> Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($bd_lead) ? null : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2,'autocomplete'=>"off", 'placeholder' => 'Remarks'])}}
             </div>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <hr class="my-2 bg-success">
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Followup By</th>
                    <th>Remarks</th>
                    <th>Followup Date</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Followup By</th>
                    <th>Remarks</th>
                    <th>Followup Date</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($followup_data as $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-center">{{ $data->user->name }}</td>
                    <td class="text-center">{{ $data->remarks }}</td>
                    <td class="text-center">{{ date_format($data->created_at, "d-m-Y") }}</td>
                    
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@section('script')
<script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>

@section('script')
    <script>
        const material_row_data = @json(old('material_id', []));
        const CSRF_TOKEN = "{{ csrf_token() }}";



        
    </script>
@endsection
