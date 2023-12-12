@extends('layouts.backend-layout') @section('title', 'Late Attendance Report')
@section('breadcrumb-title') 
Late Attendance Report @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 140px !important;
    }
    .submit_btn{
        cursor: auto;
    }
</style>
@endsection @section('breadcrumb-button')
<!-- <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('fix-attendances.index') }}"><i class="fas fa-database"></i></a> -->
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content')

    <div class="row px-4 py-2">    
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="year">From Date <span class="text-danger">*</span></label>
                {{ Form::date(
                'from_date',
                old('from_date')
                ? old('from_date')
                :null,
                ['class' => 'form-control', 'id' => 'from_date', 'placeholder' => 'Enter Date Here', 'required'],
                ) }}

                @error('from_date')
                <p class="text-danger">{{ $errors->first('from_date') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="year">To Date <span class="text-danger">*</span></label>
                {{ Form::date(
                'to_date',
                old('to_date')
                ? old('to_date')
                :null,
                ['class' => 'form-control', 'id' => 'to_date', 'placeholder' => 'Enter Date Here'],
                ) }}

                @error('to_date')
                <p class="text-danger">{{ $errors->first('to_date') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="offset-md-2 col-md-6">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2 submit_btn" onclick="getSearchData()">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- table list -->
    <div class="row mt-4 mx-2">
        <div class="col-md-12">
            <table id="lateReportTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="30%">Emp. Name</th>
                        <th width="20%">Emp. Code</th>
                        <th width="20%">Shift Name</th>
                        <th width="30%">Total Late Hour</th>
    
                    </tr>
                </thead>
                <tbody id="latetable_content">
                    <tr>
                        <td colspan='4'>
                            No Data Found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection 
@section('script')

<script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $('#employeeTable').DataTable({
        stateSave: true,
        bPaginate: false,
    });
    $('.dataTables_info').css('display', 'none');
</script>

{{-- use for disabled today to before one month --}}
<script>
    let today = new Date();
    let oneMonthAgo = new Date(today);
    oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
    let formattedDate = oneMonthAgo.toISOString().split('T')[0];

    document.getElementById("from_date").setAttribute("min", formattedDate);
</script>
<script>

    function getSearchData(){
        let from_date=$('#from_date').val();
        let to_date=$('#to_date').val();
        if (from_date === "") {
            alert("From date field is required");
            return;
        }
        if (to_date === "") {
            alert("To date field is required");
            return;
        }
        $.ajax({
            url: "{{ route('getlatedata') }}",
            type: "POST",
            data: {
                from_date: from_date,
                to_date: to_date,
                _token: "{{ csrf_token() }}",
            },
            success: function(res) {
                // console.log(res);
                $('table tbody tr').hide();
                $.each(res, function(index, data) {
                    dataLoad(index, data);
                });
            },
        });
    }

    function dataLoad(index, data){
        console.log(data);
        var rowHtml = `<tr class="tr_${index}">
                        <td>${data.emp_name}</td>
                        <td>${data.emp_code}</td>
                        <td>${data.shift_name}</td>
                        <td>${((data.total_late!==null)?data.total_late:"00:00:00")}</td>
                    </tr>`;
        $('#latetable_content').append(rowHtml);
    }
</script>
@endsection
