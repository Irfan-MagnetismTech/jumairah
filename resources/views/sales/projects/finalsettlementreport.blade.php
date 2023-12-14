@extends('layouts.backend-layout')
@section('title', 'Final Settlement')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
   Final settlement
@endsection

@section('breadcrumb-button')
    {{--<a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection

@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{$request->project_name ?? null}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{$request->project_id ?? null}}">
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0" data-toggle="tooltip" title="Client Name">
                <select name="sell_id" id="sell_id" class="form-control form-control-sm" required>
                    @foreach($clients as $stat)
                        <option value="{{$stat}}" {{($stat == $current_status) ? "selected" : null}}>{{$stat}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if(!empty($request))
    <div class="table-responsive">

    </div>
    @endif
@endsection

@section('script')
    <script>
        function loadSoldClientsWithApartment(){
            let dropdown = $('#sell_id');
            let oldSelectedItem = "{{!empty($client) ? $client : null}}";

            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Client </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadSoldClientsWithApartment")}}/' + $("#project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (items) {
                $.each(items, function (key, entry) {
                    let select=(oldSelectedItem == entry.id) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', entry.id).text(`${entry.sell_client.client.name} [Apartment : ${entry.apartment.name}]`));
                })
            });
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $("#project_name").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{route('projectAutoSuggest')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            }).change(function(){
                if(!$(this).val()){
                    $('#project_id').val(null);
                }
                loadSoldClientsWithApartment();
            });

            @if($request->sell_id)
                loadSoldClientsWithApartment();
            @endif

        });//document.ready
    </script>
@endsection
