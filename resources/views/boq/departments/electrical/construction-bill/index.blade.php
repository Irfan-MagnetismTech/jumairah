@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Calculation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of  Construction Bills
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction-bills/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($constructionBills) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead class="">
                <tr>
                    <th>SL</th>
                    <th> Date </th>
                    <th> Title </th>
                    <th> Work Type </th>
                    <th> Project </th>
                    <th> Supplier </th>
                    <th> Bill No </th>
                    <th> Reference No </th>
                    <th> Bill Amount </th>
                    <th> Prepared By </th>
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>

            <tbody>
            @foreach($constructionBills as $constructionBill)

            @if ($constructionBill->is_saved == 1 || (auth()->user()->id == $constructionBill->user_id && $constructionBill->is_saved == 0))
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$constructionBill->bill_received_date ?? null}}</td>
                    <td>{{$constructionBill->title ?? null}}</td>
                    <td>{{$constructionBill->work_type ?? null}}</td>
                    <td>{{$constructionBill->project->name ?? null}}</td>
                    <td>{{$constructionBill->supplier->name ?? null}}</td>
                    @if (empty($constructionBill->bill_no ?? null))
                    <td>{{ "Upcome" }}</td>
                    @else
                    <td>{{$constructionBill->bill_no ?? null}}</td>
                    @endif
                    <td>{{$constructionBill->reference_no ?? null}}</td>
                    <td>{{$constructionBill->bill_amount ?? null}}</td>
                    <td>{{$constructionBill->preparedBy->name ?? null}}</td>
                    <td> <span class="badge @if($constructionBill->status == 'Accepted') bg-success @else bg-warning @endif badge-sm"> {{$constructionBill->status}} </span> </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @if ($constructionBill->is_saved == 0)
                                        <a href="{{ url("construction-bills/$constructionBill->id/edit") }}" data-toggle="tooltip" title="Edit Draft" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a>
                                        {!! Form::open(array('url' => "construction-bills/$constructionBill->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                @else
                                    @if($constructionBill->status != 'Accepted')
                                        <a href="{{ url("construction-bill-approval/$constructionBill->id") }}" data-toggle="tooltip" title="Approval" class="btn btn-outline-success">Approve</a>
                                    @endif
                                        <a href="{{ url("construction-bills/$constructionBill->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ url("constructionbillpdf/$constructionBill->id") }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file"></i></a>
                                    @if($constructionBill->status != 'Accepted')
                                        <a href="{{ url("construction-bills/$constructionBill->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open(array('url' => "construction-bills/$constructionBill->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                    @endif
                                @endif

                            </nobr>
                        </div>
                    </td>
                </tr>
            @endif
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
