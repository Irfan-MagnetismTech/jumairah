@extends('layouts.backend-layout')
@section('title', 'Permission')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Permission Fees and Ors
@endsection


@section('breadcrumb-button')
    @can('employee-create')
        <a href="{{ url('employees/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection



    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Task Name</th>
                    <th>Expense Type</th>
                    <th>Unit/Job</th>
                    <th>Total Unit/Job</th>
                    <th>Expense <br>Unit/Job</th>
                    <th>Total Expense</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Task Name</th>
                    <th>Expense Type</th>
                    <th>Unit/Job</th>
                    <th>Total Unit/Job</th>
                    <th>Expense <br>Unit/Job</th>
                    <th>Total Expense</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>1</td>
                    <td> POA Appointment Permission </td>
                    <td>Permission Fees</td>
                    <td>Katha</td>
                    <td>0</td>
                    <td>40000</td>
                    <td>-</td>
                    <td>Applicable for Lease hold Property</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a  data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a  data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a  data-toggle="tooltip" title="Delete" class="btn btn-outline-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>POA & DOA Registration </td>
                    <td>Permission Fees</td>
                    <td>Katha</td>
                    <td>0</td>
                    <td>40000</td>
                    <td>-</td>
                    <td>Applicable for Lease hold Property</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a  data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a  data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a  data-toggle="tooltip" title="Delete" class="btn btn-outline-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Clearance From CDA-LUC</td>
                    <td>Permission Fees</td>
                    <td>Katha</td>
                    <td>0</td>
                    <td>40000</td>
                    <td>-</td>
                    <td>Applicable for Lease hold Property</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a  data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a  data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a  data-toggle="tooltip" title="Delete" class="btn btn-outline-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td> POA Appointment Permission </td>
                    <td>Permission Fees</td>
                    <td>Katha</td>
                    <td>0</td>
                    <td>40000</td>
                    <td>-</td>
                    <td>Applicable for Lease hold Property</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a  data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a  data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a  data-toggle="tooltip" title="Delete" class="btn btn-outline-danger btn-sm delete"><i class="fa fa-trash"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
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
