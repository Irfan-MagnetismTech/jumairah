@extends('layouts.backend-layout')
@section('title', 'Lead Generation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Lead Generation List
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bd_lead/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection


    @section('content')

            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>L/O Name</th>
                    <th>Land Location</th>
                    <th>Entry Date</th>
                    <th>Lead Stage</th>
                    <th>Last Followup</th>
                    <th>Entry By</th>
                    <th>Source</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>L/O Name</th>
                    <th>Land Location</th>
                    <th>Entry Date</th>
                    <th>Lead Stage</th>
                    <th>Last Followup</th>
                    <th>Entry By</th>
                    <th>Source</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($bd_lead_data as $key => $data)
            @php
                $followup_data = App\BD\BdleadFollowUp::where('bd_lead_generation_id', $data->id)->latest()->get();
            @endphp
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td>
                        @foreach($data->BdLeadGenerationDetails as $row)
                            {{ $row->name }},
                        @endforeach
                    </td>
                    <td> {{ $data->land_location }} </td>
                    <td> {{ date_format($data->created_at, 'd-m-Y') }} </td>
                    <td> {{ $data->lead_stage }} </td>
                    <td>
                        {{ $followup_data->isNotEmpty() ? date_format($followup_data[0]->created_at, 'd-m-Y' )  : null }}
                    </td>
                    <td> {{ $data->user ? $data->user->name : '' }} </td>
                    <td> {{ $data->source->name }} </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url('followup') }}/{{ $data->id }}" data-toggle="tooltip" title="followup" class="btn btn-outline-success"><i class="fas fa-retweet"></i></a>
                                <a href="{{ url("bd_lead/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a href="{{ url("bd_lead/$data->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                {!! Form::open(array('url' => "bd_lead/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>

@endsection
