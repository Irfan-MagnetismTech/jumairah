@extends('layouts.backend-layout')
@section('title', 'Fixed Asset')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Fixed Assets
@endsection

@section('breadcrumb-button')
    <a href="{{ route('fixed-assets.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($fixedAssets) }}
@endsection

@section('content')

    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th> SL </th>
                    <th> Received Date </th>
                    <th> Tag </th>
                    <th> Name </th>
                    <th> Department </th>
                    <th> Life Time </th>
                    <th> Brand </th>
                    <th> Model </th>
                    <th> Serial </th>
                    <th> Action </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($fixedAssets as $fixedAsset)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fixedAsset->received_date }}</td>
                        <td>{{ $fixedAsset->tag }}</td>
                        <td>{{ $fixedAsset->name }}</td>
                        <td>{{ $fixedAsset->department }}</td>
                        <td>{{ $fixedAsset->life_time }}</td>
                        <td>{{ $fixedAsset->brand }} </td>
                        <td>{{ $fixedAsset->model }}</td>
                        <td>{{ $fixedAsset->serial }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route("fixed-assets.show", $fixedAsset->id) }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route("fixed-assets.edit", $fixedAsset->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "accounts/fixed-assets/$fixedAsset->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
