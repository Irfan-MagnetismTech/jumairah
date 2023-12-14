@extends('layouts.backend-layout')
@section('title', 'Material Ledger')

@section('style')
@endsection

@section('breadcrumb-title')
    Material Ledger
@endsection


@section('sub-title')

@endsection

@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{$project_name ?? $project_name}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{$project_id ?? $project_id}}">
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="material_name" name="material_name" class="form-control form-control-sm" value="" placeholder="Enter material Name" autocomplete="off">
                <input type="hidden" id="material_id" name="material_id" class="form-control form-control-sm" value="">
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead style="background-color:white!important;">
                <tr style="height:2rem;border:none;background-color:white!important;">
                    <td colspan="16"></td>
                </tr>
                <tr style="background-color:white!important;">
                    <th rowspan="2">Date OF Ladger Entry</th>
                    <th colspan="2">Received From Purchase</th>
                    <th rowspan="2">Cumulative Received Purchase</th>
                    <th colspan="2">Received From Other Project</th>
                    <th rowspan="2">Cumulative Received (Other Site)</th>
                    <th rowspan="2">Cumulative Gross Received</th>
                    <th colspan="2">Transfer To Other Project</th>
                    <th rowspan="2">Cumulative Transfer To other project</th>
                    <th rowspan="2">Net Cumulative Received</th>
                    <th colspan="2">Issued For Work at site</th>
                    <th rowspan="2">Cumulative Issed for work at site</th>
                    <th rowspan="2">Balance Quantity</th>
                </tr>
                <tr style="background-color:white!important;">
                    <th>MRR NO</th>
                    <th>Quantity</th>
                    <th>MTI NO</th>
                    <th>Quantity</th>
                    <th>MTO No</th>
                    <th>Quantity</th>
                    <th>Sin No</th>
                    <th>Quantity</th>
                </tr>
                <tr style="background-color:white!important;">
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8 = (4+7)</td>
                    <td>9 </td>
                    <td>10</td>
                    <td>11</td>
                    <td>12 = (8-11)</td>
                    <td>13</td>
                    <td>14</td>
                    <td>15</td>
                    <td>16 = (12-15)</td>
                </tr>
                </thead>
            <tbody class="text-right">
            @php
                $totalPaid = 0;
                $totalDueTillDate = 0;
            @endphp
            {{-- @forelse($data_groups as $key => $value)
            <tr>
                <td >{{ $key }}</td>
                <td>
                    @if (isset($receive_from_purchase[$key]))
                        @forelse ($receive_from_purchase[$key]['item'] as $data)
                            {{ $data->MaterialReceive->mrr_no }} <br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif
                </td>

                <td>
                    @if (isset($receive_from_purchase[$key]))
                        @forelse ($receive_from_purchase[$key]['item'] as $data)
                        {{ $data->quantity }} <br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif

                </td>
                <td >{{ $cumulative_purchase }}</td>
                <td>
                    @if (isset($movement_In[$key]))
                    @forelse ($movement_In[$key]['item'] as $kk =>$data)
                        {{ $data->movementin->mti_no ?? 'N/A'}}<br />
                    @empty
                            0
                    @endforelse
                @else
                            0
                @endif
                </td>
                <td>
                    @if (isset($movement_In[$key]))
                        @forelse ($movement_In[$key]['item'] as $data)
                        {{ $data->quantity }} <br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif
                </td>
                <td>{{ $cumulative_movement_in }}</td>
                <td>{{ $cumulative_purchase + $cumulative_movement_in }}</td>
                <td>
                    @if (isset($movement_out[$key]))
                        @forelse ($movement_out[$key]['item'] as $data)
                        {{ $data->movementout?->mto_no ?? ''}} <br />
                        @empty
                                0
                        @endforelse
                    @else
                                0
                    @endif
                </td>
                <td>
                    @if (isset($movement_out[$key]))
                    @forelse ($movement_out[$key]['item'] as $data)
                    {{ $data->quantity }} <br />
                    @empty
                            0
                    @endforelse
                @else
                            0
                @endif
                </td>
                <td>{{ $cumulative_movement_out }}</td>
                <td>{{ $cumulative_purchase + $cumulative_movement_in - $cumulative_movement_out }}</td>
                <td>
                    @if (isset($issued_for_work_site[$key]))
                        @forelse ($issued_for_work_site[$key]['item'] as $data)
                            {{ $data->storeIssue->sin_no }} <br />
                        @empty
                               N/A
                        @endforelse
                    @else
                               N/A
                    @endif
                </td>
                <td>
                @if (isset($issued_for_work_site[$key]))
                    @forelse ($issued_for_work_site[$key]['item'] as $data)
                    {{ $data->quantity }} <br />
                    @empty
                            0
                    @endforelse
                @else
                            0
                @endif
                </td>
                <td>{{ $cumulative_issued_for_worksite }}</td>
                <td>{{  $cumulative_purchase + $cumulative_movement_in - $cumulative_movement_out - $cumulative_issued_for_worksite }}</td>
            </tr> --}}
            {{-- @empty --}}
                <tr class="text-center">
                    <td colspan="20"> <h6 class="text-muted my-3"> Please Enter a Project Name. </h6> </td>
                </tr>
            {{-- @endforelse --}}

            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
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
            });
        });//document.ready
    </script>
@endsection
