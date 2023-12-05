@extends('layouts.backend-layout')
@section('title', 'Revenue')

@section('breadcrumb-title')
    Feasibility Revenue
@endsection

@section('breadcrumb-button')
    <a href="{{ url('revenue') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if ($formType == 'edit')
        {!! Form::open(['url' => "revenue/$revenue->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'revenue', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif

    <div class="row">
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="document">Location<span class="text-danger">*</span></label>
                {{ Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($revenue->location_id) ? $revenue->location_id : null), ['class' => 'form-control location_id', 'id' => 'location_id', 'placeholder' => 'Select Location', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon text-center" for="mgc">Proposed MGC</label>
                {{ Form::text('proposed_mgc', old('proposed_mgc') ? old('proposed_mgc') : (!empty($storyData->proposed_mgc) ? $storyData->proposed_mgc : 0), ['class' => 'form-control text-center', 'id' => 'proposed_mgc', 'autocomplete' => 'off','tabindex' => '-1','readonly']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon text-center" for="proposed_far">Proposed FAR</label>
                {{ Form::text('proposed_far', old('proposed_far') ? old('proposed_far') : (!empty($storyData->proposed_far) ? $storyData->proposed_far : 0), ['class' => 'form-control text-center', 'id' => 'proposed_far', 'autocomplete' => 'off','tabindex' => '-1','readonly']) }}
            </div>
        </div>
      
        
       
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="document">Proposed Saleable <br/>Sft<span class="text-danger">*</span></label>
                {{ Form::text('proposed_saleable_sft', old('proposed_saleable_sft') ? old('proposed_saleable_sft') : (isset($total_saleable_area) && $total_saleable_area ? $total_saleable_area : 0), ['class' => 'form-control proposed_saleable_sft', 'id' => 'proposed_saleable_sft', 'placeholder' => '', 'autocomplete' => 'off','readonly']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="document">Ground Floor Sft<span class="text-danger">*</span></label>
                {{ Form::text('ground_floor_sft', old('ground_floor_sft') ? old('ground_floor_sft') : (!empty($revenue->ground_floor_sft) ? $revenue->ground_floor_sft : null), ['class' => 'form-control ground_floor_sft', 'id' => 'ground_floor_sft', 'placeholder' => 'Saleable Ground Floor', 'autocomplete' => 'off']) }}

            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon text-center" for="mgc">MGC</label>
                {{ Form::text('mgc', old('mgc') ? old('mgc') : (!empty($revenue->mgc) ? $revenue->mgc : null), ['class' => 'form-control text-center', 'id' => 'mgc', 'autocomplete' => 'off','tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon text-center" for="actual_far">Actual FAR</label>
                {{ Form::text('actual_far', old('actual_far') ? old('actual_far') : (!empty($revenue->actual_far) ? $revenue->actual_far : null), ['class' => 'form-control text-center', 'id' => 'actual_far', 'autocomplete' => 'off','tabindex' => '-1']) }}
            </div>
        </div>
       
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="document">Total Saleable Sft<span class="text-danger">*</span></label>
                {{ Form::text('total_saleable_sft', old('total_saleable_sft') ? old('total_saleable_sft') : (!empty($revenue->total_saleable_sft) ? $revenue->total_saleable_sft : null), ['class' => 'form-control total_saleable_sft', 'id' => 'total_saleable_sft', 'placeholder' => '', 'autocomplete' => 'off','readonly']) }}
            </div>
        </div>
        
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon text-center" for="document">G+</label>
                {{ Form::text('actual_story', old('actual_story') ? old('actual_story') : (!empty($revenue->actual_story) ? $revenue->actual_story : null), ['class' => 'form-control text-center', 'id' => 'proposed_story', 'autocomplete' => 'off','tabindex' => '-1']) }}
            </div>
        </div>
        
       
        {{-- <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" style="width:100px!important;" for="document">Revenue From Parking and
                    Utility*<span
                        class="text-danger"></span></label>{{ Form::text('revenue_from_parking', old('revenue_from_parking') ? old('revenue_from_parking') : (!empty($revenue->revenue_from_parking) ? $revenue->revenue_from_parking : null), ['class' => 'form-control revenue_from_parking', 'id' => 'revenue_from_parking', 'placeholder' => 'Revenue From Parking And Utility', 'autocomplete' => 'off']) }}
            </div>
        </div> --}}
    </div>
    <hr />
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
                <thead>
                    <tr>
                        <th>Floor</th>
                        <th>Floor(SFT)</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>
                            {{-- <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button> --}}
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @if (old('floor_no'))
                        @foreach (old('floor_no') as $key => $materialOldData)
                            <tr>
                                <td>
                                    <input type="hidden" name="floor_id[]" value="{{ old('floor_id')[$key] }}"
                                        class="floor_id">
                                    <input type="text" name="floor_name[]" value="{{ old('floor_name')[$key] }}"
                                        class="form-control form-control-sm floor_name" autocomplete="off">
                                </td>
                                {{-- <td><input type="text" name="floor_no[]"  value="{{old('floor_no')[$key]}}" class="form-control text-center form-control-sm floor_no individual_floor_sft" autocomplete="off"></td> --}}
                                <td><input type="text" name="floor_sft[]" value="{{ old('floor_sft')[$key] }}"
                                        class="form-control text-center form-control-sm floor_sft" autocomplete="off"></td>
                                <td><input type="text" name="rate[]" value="{{ old('rate')[$key] }}"
                                        class="form-control text-center form-control-sm rate" autocomplete="off"></td>
                                <td><input type="text" name="total[]" value="{{ old('total')[$key] }}"
                                        class="form-control text-center form-control-sm total" tabindex="-1" readonly></td>
                                <td>{{-- <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button>
                                     --}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @if (!empty($revenue))
                            @foreach ($revenue->BdFeasiRevenueDetail as $data)
                                @php
                                    if ($data->floor_id == $ground_floor->id) {
                                        $className = 'ground_floor';
                                        $className_rounded = 'ground_floor_rounded';
                                    } else {
                                        $className = 'individual_floor_sft';
                                        $className_rounded = 'individual_floor_sft_rounded';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <input type="hidden" name="floor_id[]" value="{{ $data->floor_id }}"
                                            class="floor_id">
                                        <input type="text" name="floor_name[]" value="{{ $data->BoqFloor->name }}"
                                            class="form-control form-control-sm floor_name" autocomplete="off">
                                    </td>
                                    {{-- <td><input type="text" name="floor_no[]"  value="{{ $data->floor_no }}" class="form-control text-center form-control-sm text-center floor_no"  autocomplete="off"></td> --}}
                                    <td>
                                        <input type="hidden" name="floor_sft[]" value="{{ $data->floor_sft }}" class="form-control text-center form-control-sm floor_sft {{ $className }}" autocomplete="off">
                                        <input type="text" name="floor_sft_rounded[]" value="{{ round($data->floor_sft, 2)}}" class="form-control text-center form-control-sm floor_sft_rounded {{ $className_rounded }}" autocomplete="off">
                                    </td>
                                    <td><input type="text" name="rate[]" value="{{ round($data->rate, 2) }}"
                                            class="form-control text-center form-control-sm rate" autocomplete="off"></td>
                                    <td>
                                        <input type="hidden" name="total[]" value="{{ $data->total }}" class="form-control text-center form-control-sm total" tabindex="-1" readonly>
                                        <input type="text" name="total_rounded[]" value="{{ round($data->total, 2)}}" class="form-control text-center form-control-sm total_rounded" tabindex="-1" readonly>
                                    </td>
                                    <td>
                                        {{-- <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                                class="fa fa-minus"></i></button>
                                         --}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td>
                            <input type="text" name="total_floor_sft_rounded"
                                value="{{ old('total_floor_sft_rounded') ? old('total_floor_sft_rounded') : (!empty($revenue->total_floor_sft) ? round($revenue->total_floor_sft, 2) : null) }}"
                                class="form-control text-center form-control-sm total_floor_sft_rounded" autocomplete="off" readonly
                                id="total_floor_sft_rounded">
                            <input type="hidden" name="total_floor_sft"
                                value="{{ old('total_floor_sft') ? old('total_floor_sft') : (!empty($revenue->total_floor_sft) ? $revenue->total_floor_sft : null) }}"
                                class="form-control text-center form-control-sm total_floor_sft" autocomplete="off" readonly
                                id="total_floor_sft">
                        </td>
                        <td>
                            <input type="text" name="avg_rate_rounded"
                                value="{{ old('avg_rate_rounded') ? old('avg_rate_rounded') : (!empty($revenue->avg_rate) ? round($revenue->avg_rate, 2) : null) }}"
                                class="form-control text-center form-control-sm avg_rate_rounded" autocomplete="off" readonly
                                id="avg_rate_rounded">
                            <input type="hidden" name="avg_rate"
                                value="{{ old('avg_rate') ? old('avg_rate') : (!empty($revenue->avg_rate) ? $revenue->avg_rate : null) }}"
                                class="form-control text-center form-control-sm avg_rate" autocomplete="off" readonly
                                id="avg_rate">
                        </td>
                        <td>
                            <input type="text" name="total_amount_rounded"
                                value="{{ old('total_amount_rounded') ? old('total_amount_rounded') : (!empty($revenue->total_amount) ? round($revenue->total_amount, 2) : null) }}"
                                class="form-control text-center form-control-sm total_amount_rounded" tabindex="-1" readonly
                                id="total_amount_rounded">
                            <input type="hidden" name="total_amount"
                                value="{{ old('total_amount') ? old('total_amount') : (!empty($revenue->total_amount) ? $revenue->total_amount : null) }}"
                                class="form-control text-center form-control-sm total_amount" tabindex="-1" readonly
                                id="total_amount">
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
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
@endsection

@section('script')

    <script>
        var ground_floor = null;
        var global_floor = null;
        var global_total_buildup_area = 0;
        var global_katha = 0;
        var global_rfpl = 0;
       
        @if ($formType == 'edit')
            ground_floor = {!! $ground_floor !!};
            global_floor = {!! collect($floors) !!};
            global_total_buildup_area = {!! (float)$global_total_buildup_area !!};
            global_katha = {!! (float)$land_size !!};
            global_rfpl = {!! (float)$rfpl !!};
        @endif
        function addRow(floor_id = null, floor_name = null, floor_sft = 0,floor_sft_rounded = 0, floor_class = null,floor_class_rounded = null) {
            let row = `
                    <tr>
                        <td>
                        <input type="hidden" name="floor_id[]" value="${floor_id}" class="floor_id" required>
                        <input type="text" name="floor_name[]" value="${floor_name}" class="form-control form-control-sm floor_name" autocomplete="off">
                    </td>
                    <td>
                        <input type="hidden" name="floor_sft[]" value="${floor_sft}" class="form-control text-center form-control-sm floor_sft ${floor_class}" autocomplete="off">
                        <input type="text" name="floor_sft_rounded[]" value="${floor_sft_rounded}" class="form-control text-center form-control-sm floor_sft_rounded ${floor_class_rounded}" autocomplete="off">
                    </td>
                    <td><input type="text" name="rate[]" class="form-control text-center form-control-sm rate" autocomplete="off"></td>
                    <td>
                        <input type="hidden" name="total[]" class="form-control text-center form-control-sm total" tabindex="-1" readonly>
                        <input type="text" name="total_rounded[]" class="form-control text-center form-control-sm total_rounded" tabindex="-1" readonly>
                    </td>
                    <td>
                        
                    </td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateTotal(this);
            SumOfFloor();
            SumOfAmount();
            AverageRate();
        }


        $("#itemTable").on('click', ".addItem", function() {
            addRow();
            let g_floor = $('.ground_floor');
            let total_floor_sft = Number($('#total_floor_sft').val()) - Number($('#ground_floor_sft').val());
            let proposed_story = $('#proposed_story').val();
            // let story = proposed_story.split(" ");
            var floor = Math.floor(proposed_story);
            let individual_sft = (total_floor_sft / floor);
            let individual_sft_rounded = (total_floor_sft / floor).toFixed(2);
            $('.individual_floor_sft').val(individual_sft);
            $('.individual_floor_sft_rounded').val(individual_sft_rounded);
        }).on('click', '.deleteItem', function() {
            $(this).closest('tr').remove();
            calculateTotal(this);
            SumOfFloor();
            SumOfAmount();
            AverageRate();
        });


        var CSRF_TOKEN = "{{ csrf_token() }}";
        $("#location_id").on('change', function() {
            $("#actual_far").val('')
            $('#proposed_far').val('');
            $('#proposed_story').val();
            $('#mgc').val();
            $('#ground_floor_sft').val();
            $('#total_saleable_sft').val();
            $('#proposed_saleable_sft').val();
            $('#itemTable tbody').empty();
            $('#total_floor_sft_rounded').val('');
            $('#total_floor_sft').val('');
            $('#avg_rate_rounded').val('');
            $('#avg_rate').val('');
            $('#total_amount_rounded').val('');
            $('#total_amount').val('');

            $.ajax({
                url: "{{ route('scj.getProposedStory') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    location_id: $("#location_id").val(),
                },
                success: function(data) {
                        $('#proposed_far').val(data.total_far ?? 0);
                        $('#proposed_mgc').val(data.proposed_mgc ?? 0);
                        let total_buildup_area = Number(data.total_far) * Number(data.land_size) * 720;
                        let total_bonus_saleable_area = Number(data.total_far) * Number(data
                            .land_size) * 720 * Number(data.bonus_saleable_area) / 100;
                        let total_saleable_area = (total_buildup_area + total_bonus_saleable_area) *
                            Number(data.rfpl_ratio) / 100; 
                        $('#proposed_saleable_sft').val(total_saleable_area);
                        return false;
                }
            });
        });

        $("#actual_far").on('change', function() {
            if($('#mgc').val() == "" || $('#mgc').val() == null || $('#mgc').val() == 0) {
                alert('Please select mgc first');
                return false;
            }
            $.ajax({
                url: "{{ route('scj.getProposedStory') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    location_id: $("#location_id").val(),
                },
                success: function(data) {

                    
                        ground_floor = data.floor[0];
                        global_floor = data.floor;
                        let actual_far = $("#actual_far").val();
                        $('#itemTable tbody').empty();
                        let total_buildup_area = global_total_buildup_area = Number(actual_far) * Number(data.land_size) * 720;
                        global_katha = Number(data.land_size);
                        global_rfpl = Number(data.rfpl_ratio);
                        let total_bonus_saleable_area = Number(actual_far) * Number(data
                            .land_size) * 720 * Number(data.bonus_saleable_area) / 100;
                        let total_saleable_area = (total_buildup_area + total_bonus_saleable_area) *
                            Number(data.rfpl_ratio) / 100; 
                       
                        
                        let new_floor = Math.ceil((global_total_buildup_area-getUtilization()*(Number($('#mgc').val())/100)*global_katha*720)/((Number($('#mgc').val())/100)*global_katha*720));
                        console.log('new_floor',new_floor);
                        console.log(((Number($('#mgc').val())/100)*global_katha*720));
                        $('#proposed_story').val(new_floor);
                        let g_sft = $('#ground_floor_sft').val() > 0 ?  Number($('#ground_floor_sft').val()) : 0;
                        $('#ground_floor_sft').val(g_sft);
                        $('#total_saleable_sft').val(total_saleable_area);    
                        /*****/

                       

                        let total_floor_sft = Number(total_saleable_area) - Number(g_sft);
                        let individual_sft_rounded = (total_floor_sft / new_floor).toFixed(2);
                        let individual_sft = (total_floor_sft / new_floor).toFixed(8);
                        let ground_sft_rounded = Number(g_sft).toFixed(2);
                        let ground_sft = Number(g_sft).toFixed(8);
                        $('#itemTable tbody').empty();
                        console.log(data.floor);
                        for (let i = 1; i <= new_floor; i++) {
                            addRow(data.floor[i].id, data.floor[i].name,individual_sft,individual_sft_rounded,'individual_floor_sft','individual_floor_sft_rounded');
                        }
                        if(g_sft > 0){
                            addRow(ground_floor.id, ground_floor.name,ground_sft,ground_sft_rounded,'ground_floor','ground_floor_rounded');
                        }

                        /*****/
                                          
                        SumOfFloor();
                        SumOfAmount();
                        AverageRate();

                    return false;
                }
            });
        });


        $(document).on('keyup change', '.floor_sft_rounded,.rate', function() {
            calculateTotal(this);
            SumOfFloor();
            SumOfAmount();
            AverageRate();
        });
        $('#ground_floor_sft').on('change', function() {
            let g_floor = $('.ground_floor');
            let total_floor_sft = Number($('#total_saleable_sft').val()) - Number($(this).val());
            let proposed_story = $('#proposed_story').val();
            // let story = proposed_story.split(" ");
            var floor = Math.floor(proposed_story);
            let individual_sft_rounded = (total_floor_sft / floor).toFixed(2);
            let individual_sft = (total_floor_sft / floor).toFixed(8);
            $('.individual_floor_sft').val(individual_sft);
            $('.individual_floor_sft_rounded').val(individual_sft_rounded);
            let ground_sft_rounded = Number($(this).val()).toFixed(2);
            let ground_sft = Number($(this).val()).toFixed(8);
            if (g_floor.length) {
                
                $('.ground_floor').val(ground_sft);
                $('.ground_floor_rounded').val(ground_sft_rounded);
            } else {
                addRow(ground_floor.id, ground_floor.name,ground_sft,ground_sft_rounded,'ground_floor','ground_floor_rounded');
            }
            SumOfFloor();
            SumOfAmount();
            AverageRate();

        })

        function getUtilization(){
            let g_sft = $('#ground_floor_sft').val();
                if(g_sft > 0){
                    utilization = (Number(g_sft) / global_rfpl / 100) / (global_katha * 720 * Number($('#mgc').val())) * 100;
                }else{
                    utilization = 0;
                }
                return utilization;
        }

        $('#proposed_story').on('change',function(){
            getGNewFloorAndRow()
        })


        function getGNewFloorAndRow(){
            let flor = $('#proposed_story').val();
            // let new_mgc = Math.ceil((global_total_buildup_area-getUtilization()*(Number($('#mgc').val())/100)*global_katha*720)/((Number($('#mgc').val())/100)*global_katha*720));

            
            // let new_floor = Math.ceil((global_total_buildup_area-getUtilization()*(Number($('#mgc').val())/100)*global_katha*720)/((Number($('#mgc').val())/100)*global_katha*720));
            // $('#proposed_story').val(new_floor);
            let g_sft = $('#ground_floor_sft').val();

            let total_floor_sft = Number($('#total_saleable_sft').val()) - Number(g_sft);
            let individual_sft_rounded = (total_floor_sft / flor).toFixed(2);
            let individual_sft = (total_floor_sft / flor).toFixed(8);
            let ground_sft_rounded = Number(g_sft).toFixed(2);
             let ground_sft = Number(g_sft).toFixed(8);
             $('#itemTable tbody').empty();
             for (let i = 1; i <= flor; i++) {
                 addRow(global_floor[i].id, global_floor[i].name,individual_sft,individual_sft_rounded,'individual_floor_sft','individual_floor_sft_rounded');
             }
             if(g_sft > 0){
                 addRow(ground_floor.id, ground_floor.name,ground_sft,ground_sft_rounded,'ground_floor','ground_floor_rounded');
             }
        }


        $('#mgc').on('change',function(){
            getNewFloorAndRow()
        })
        function getNewFloorAndRow(){
            let new_floor = Math.ceil((global_total_buildup_area-getUtilization()*(Number($('#mgc').val())/100)*global_katha*720)/((Number($('#mgc').val())/100)*global_katha*720));
            $('#proposed_story').val(new_floor);
            let g_sft = $('#ground_floor_sft').val();

            let total_floor_sft = Number($('#total_saleable_sft').val()) - Number(g_sft);
            let individual_sft_rounded = (total_floor_sft / new_floor).toFixed(2);
            let individual_sft = (total_floor_sft / new_floor).toFixed(8);
            let ground_sft_rounded = Number(g_sft).toFixed(2);
             let ground_sft = Number(g_sft).toFixed(8);
             $('#itemTable tbody').empty();
             for (let i = 1; i <= new_floor; i++) {
                 addRow(global_floor[i].id, global_floor[i].name,individual_sft,individual_sft_rounded,'individual_floor_sft','individual_floor_sft_rounded');
             }
             if(g_sft > 0){
                 addRow(ground_floor.id, ground_floor.name,ground_sft,ground_sft_rounded,'ground_floor','ground_floor_rounded');
             }
        }
        // Function for calculating total Road SFT
        function calculateTotal(thisVal) {
            let floor_sft = $(thisVal).closest('tr').find('.floor_sft').val() > 0 ? parseFloat($(thisVal).closest('tr')
                .find('.floor_sft').val()) : 0;
            let rate = $(thisVal).closest('tr').find('.rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.rate')
                .val()) : 0;
            let total = (floor_sft * rate);
            let total_rounded = (floor_sft * rate).toFixed(2);
            $(thisVal).closest('tr').find('.total').val(total);
            $(thisVal).closest('tr').find('.total_rounded').val(total_rounded);
        }

        $(document).on('change', '.floor_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.feasiFloorAutoSuggest') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('.floor_id').val(ui.item.value);
                    $(this).closest('tr').find('.floor_name').val(ui.item.label);
                    return false;
                }
            })
        })

        function SumOfFloor() {
            let total = 0;
            $(".floor_sft").each(function() {
                total += Number($(this).val());
            });

            $('#total_floor_sft_rounded').val(total.toFixed(2));
            $('#total_floor_sft').val(total);
        }

        function SumOfAmount() {
            let total = 0;
            $(".total").each(function() {
                total += Number($(this).val());
            });
            $('#total_amount_rounded').val(total.toFixed(2));
            $('#total_amount').val(total);
        }

        function AverageRate() {
            let total_floor_sft = $('#total_floor_sft').val() > 0 ? $('#total_floor_sft').val() : 0;
            let total_amount = $('#total_amount').val() > 0 ? $('#total_amount').val() : 0;
            // console.log(total_floor_sft, total_amount);
            var average = 0;
            if (total_amount > 0) {
                average = total_amount / total_floor_sft;
            }
            $('#avg_rate_rounded').val(average.toFixed(2));
            $('#avg_rate').val(average);
        }
       
        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection

