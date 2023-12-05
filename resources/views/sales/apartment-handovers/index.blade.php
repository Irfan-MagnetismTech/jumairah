@extends('layouts.backend-layout')
@section('title', 'Apartment Handover')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Apartment Handover
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ route('apartment-handovers.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    Total: {{ count($sells) }}
@endsection

    @section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client Name</th>
                    <th>Project Name </th>
                    <th>Apartment ID</th>
                    <th>Sold Date</th>
                    <th>Total Value</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Handover Date</th>
                    <th>Sold By</th>
                    <th>Status </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($sells as $key => $sell)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="breakWords">{{$sell->sellClient->client->name}}</td>
                    <td>{{$sell->apartment->project->name}}</td>
                    <td>{{$sell->apartment->name}}</td>
                    <td>{{$sell->sell_date}}</td>
                    <td>{{$sell->total_value}}</td>
                    <td>{{$sell->salesCollections->sum('received_amount')}}</td>
                    <td>{{$sell->total_value - $sell->salesCollections->sum('received_amount')}}</td>
                    <td>{{$sell->handover->handover_date}}</td>
                    <td>{{$sell->user->name}}</td>
                    <td>
                        <span class="badge bg-warning badge-sm status"> {{$sell->handover->status}} </span>
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @if($sell->handover->status != "Complete")
                                    <button data-toggle="tooltip" title="Approve" class="btn btn-success approveBtn" id="{{$sell->handover->id}}"> Approve  </button>
                                @endif
                                <a href="{{route('apartment-handovers.edit', $sell->handover->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                {!! Form::open(array('url' => route('apartment-handovers.destroy', $sell->handover->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
{{--                                {!! Form::open(array('url' => route('apartment-handover-approval', $sell->handover->id),'method' => 'post', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}--}}
{{--                                    <input type="hidden" name="handover_id" value="{{$sell->handover->id}}">--}}
{{--                                {{ Form::button('<i class="">Handover</i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}--}}
{{--                                {!! Form::close() !!}--}}
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

            var CSRF_TOKEN = "{{csrf_token()}}";
            $(document).on('click', ".approveBtn", function(){
                let handover_id = $(this).attr('id');
				$.ajax({
					type: 'post',
					url: 'apartment-handover-approval',
					data: {handover_id:handover_id, _token:CSRF_TOKEN},
					dataType: 'html',
					success: function (Response) {
                        // console.log(Response);
                        location.reload();
					}
				});
                // alert("Hello");
            });

{{--             <a href="{{route('apartment-handover-approval', $sell->handover->id)}}"> Approve </a>--}}

        });
    </script>
@endsection
