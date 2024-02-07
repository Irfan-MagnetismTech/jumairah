@extends('layouts.backend-layout')

@section('title', 'Sales Create')
@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Sell
    @else
        Add New Sell
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "sells/$sell->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "sells",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <input type="hidden" name="sell_id" value="{{!empty($sell) ? $sell->id : null}}">
    <div class="row">
        <div class="col-xl-12 col-md-12">
    <div class="section">
        <div class="table-responsive">
            <table id="clientTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td class="bg-success" colspan="4"> <h5 class="text-center">Client Information</h5></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Client ID </th>
                        <th>
                            @if(!empty($sell) && $sell->nameTransfers->isNotEmpty())
                            @elseif(!empty($sell) && $sell->nameTransfers->isEmpty())
                                <i class="btn btn-primary btn-sm fa fa-plus" id="addClient"> </i>
                            @else
                                <i class="btn btn-primary btn-sm fa fa-plus" id="addClient"> </i>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>

                @if(old('client_id'))
                    @foreach(old('client_id') as $key => $clientOldData)
                        <tr>
                            <td>
                                <input type="text" name="name[]" value="{{old('name')[$key]}}" class="form-control form-control-sm name" placeholder="Type Client Name"  required>
                            </td>
                            <td><input type="text" name="contact[]" value="{{old('contact')[$key]}}" class="form-control form-control-sm contact" readonly></td>
                            <td><input type="text" name="client_id[]" value="{{old('client_id')[$key]}}" class="form-control form-control-sm text-center client_id" required readonly></td>
                            <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" type="button"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if(!empty($sell) && $sell->nameTransfers->isEmpty())
                        @foreach($saleClients as $sellClient)
                            <tr>
                                <td><input type="text" name="name[]" value="{{$sellClient->client->name}}" class="form-control form-control-sm name" placeholder="Type Client Name"  required></td>
                                <td><input type="text" name="contact[]" value="{{$sellClient->client->contact}}" class="form-control form-control-sm contact" readonly ></td>
                                <td><input type="text" name="client_id[]" value="{{$sellClient->client->id}}" class="form-control form-control-sm text-center client_id" required readonly></td>
                                <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" type="button"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                    @if(!empty($sell) && $sell->nameTransfers->isNotEmpty())
                        <tr>
                            <td colspan="4"> <h5 style="color: red">This Client is Already Transfered her Name</h5> </td>
                        </tr>
                    @endif
                @endif

                </tbody>
            </table>
        </div>
    </div>
        </div>
    </div>

    <hr class="bg-success">
    <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_name">Project<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($sell->apartment->project->name) ? $sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required' ])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($sell->apartment->project->id) ? $sell->apartment->project->id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="apartment_id">Apartment ID<span class="text-danger">*</span></label>
                    {{Form::select('apartment_id',$apartments,old('apartment_id') ? old('apartment_id') : (!empty($sell->apartment_id) ? $sell->apartment_id : null),['class' => 'form-control','id' => 'apartment_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
        </div><!-- end row -->

    <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="apartment_size">Apartment Size <span class="text-danger">*</span></label>
                    {{Form::text('apartment_size', old('apartment_size') ? old('apartment_size') : (!empty($sell->apartment_size) ? $sell->apartment_size : null),['class' => 'form-control', 'id' => 'apartment_size', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off",'required'] )}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="apartment_rate">Rate (Per SFT) <span class="text-danger">*</span></label>
                    {{Form::text('apartment_rate', old('apartment_rate') ? old('apartment_rate') : (!empty($sell->apartment_rate) ? $sell->apartment_rate : null),['class' => 'form-control ', 'id' => 'apartment_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="apartment_value">Apartment Value <span class="text-danger">*</span></label>
                    {{Form::number('apartment_value', old('apartment_value') ? old('apartment_value') : (!empty($sell->apartment_value) ? $sell->apartment_value : 0),['class' => 'form-control total_price', 'id' => 'apartment_value', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="utility_no">Utility No <span class="text-danger">*</span></label>
                {{Form::text('utility_no', old('utility_no') ? old('utility_no') : (!empty($sell->utility_no) ? $sell->utility_no : 0),['class' => 'form-control', 'id' => 'utility_no', 'min'=>'0', 'placeholder' => '0.00', 'step'=>'0.01', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="utility_price">Utility Rate <span class="text-danger">*</span></label>
                {{Form::text('utility_price', old('utility_price') ? old('utility_price') : (!empty($sell->utility_price) ? $sell->utility_price : null),['class' => 'form-control ', 'id' => 'utility_price', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="utility_fees">Utility Fees<span class="text-danger">*</span></label>
                {{Form::number('utility_fees', old('utility_fees') ? old('utility_fees') : (!empty($sell->utility_fees) ? $sell->utility_fees : 0),['class' => 'form-control total_price', 'id' => 'utility_fees', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reserve_no">Reserve No <span class="text-danger">*</span></label>
                {{Form::text('reserve_no', old('reserve_no') ? old('reserve_no') : (!empty($sell->reserve_no) ? $sell->reserve_no : 0),['class' => 'form-control', 'id' => 'reserve_no', 'min'=>'0',  'placeholder' => '0.00', 'step'=>'0.01', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reserve_rate">Reserve Rate <span class="text-danger">*</span></label>
                {{Form::text('reserve_rate', old('reserve_rate') ? old('reserve_rate') : (!empty($sell->reserve_rate) ? $sell->reserve_rate : null),['class' => 'form-control ', 'id' => 'reserve_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reserve_fund">Reserve Fund <span class="text-danger">*</span></label>
                {{Form::number('reserve_fund', old('reserve_fund') ? old('reserve_fund') : (!empty($sell->reserve_fund) ? $sell->reserve_fund : 0),['class' => 'form-control total_price', 'id' => 'reserve_fund', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parking_no">Parking No <span class="text-danger">*</span></label>
                {{Form::number('parking_no', old('parking_no') ? old('parking_no') : (!empty($sell->parking_no) ? $sell->parking_no : 0),['class' => 'form-control', 'id' => 'parking_no', 'min'=>'0', 'placeholder' => '0', 'autocomplete'=>"off",'required', 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parking_price">Price of Parking <span class="text-danger">*</span></label>
                {{Form::number('parking_price', old('parking_price') ? old('parking_price') : (!empty($sell->parking_price) ? $sell->parking_price : 0),['class' => 'form-control total_price', 'id' => 'parking_price', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'required', 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="">Hand-Over Date<span class="text-danger"></span></label>
                {{Form::text('hand_over_date', old('hand_over_date') ? old('hand_over_date') : (!empty($sell->hand_over_date) ? $sell->hand_over_date :null),['class' => 'form-control ', 'id' => 'hand_over_date',  'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="">HO Grace Period<span class="text-danger"></span></label>
                {{Form::select('ho_grace_period', $months, old('ho_grace_period') ? old('ho_grace_period') : (!empty($sell->ho_grace_period) ? $sell->ho_grace_period : null),['class' => 'form-control ', 'id' => 'ho_grace_period', 'min'=>'0', 'step'=>'0.01', 'placeholder' => 'Select', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="">Rental Compensation Amount<span class="text-danger"></span></label>
                {{Form::text('rental_compensation', old('rental_compensation') ? old('rental_compensation') : (!empty($sell->rental_compensation) ? $sell->rental_compensation : 0),['class' => 'form-control ', 'id' => 'rental_compensation', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="">Cancellation Fee<span class="text-danger"></span></label>
                {{Form::text('cancellation_fee', old('cancellation_fee') ? old('cancellation_fee') : (!empty($sell->cancellation_fee) ? $sell->cancellation_fee : 0),['class' => 'form-control ', 'id' => 'cancellation_fee', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="">Transfer Fee<span class="text-danger"></span></label>
                {{Form::text('transfer_fee', old('transfer_fee') ? old('transfer_fee') : (!empty($sell->transfer_fee) ? $sell->transfer_fee : 0),['class' => 'form-control ', 'id' => 'transfer_fee', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="others">Others<span class="text-danger">*</span></label>
                {{Form::text('others', old('others') ? old('others') : (!empty($sell->others) ? $sell->others : 0),['class' => 'form-control ', 'id' => 'others', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off", ] )}}
            </div>
        </div>
    </div>
    <hr class="bg-success">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="parkingTable" class="table table-striped table-bordered table-sm text-center">
                    <tr>
                        <td class="bg-success" colspan="3"> <h5 class="text-center">Parking Information</h5></td>
                    </tr>
                    <tr>
                        <th>Parking Name</th>
                        <th>Parking Rate</th>
                        <th><i class="btn btn-success btn-sm fa fa-plus" onclick="addParking()"> </i></th>
                    </tr>
                    <tbody>

                    @if(old('parking_composite'))
                        @foreach(old('parking_composite') as $oldKey => $oldItem)
                            <tr>
                                <td>
                                    <select class ="form-control form-control-sm" id="parking_composite" name="parking_composite[]">
                                        @if(!empty($unsoldParkings))
                                        @foreach ($unsoldParkings as $key => $unsoldParking)
                                            <option value="{{$key}}" {{ $key == old('parking_composite')[$oldKey]  ? 'selected': null }}>{{$unsoldParking}}</option>
                                        @endforeach
                                            @endif
                                    </select>
                                </td>
                                <td><input type="text" name="parking_rate[]" value="{{old('parking_rate')[$oldKey]}}" class="form-control form-control-sm parking_rate" min="0" step="0.01" required></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        @if(!empty($sell))
                            @foreach($sell->soldParking as $parking)
                                <tr>
                                    <input type="hidden" name="id" value="{{(!empty($parking->id) ? $parking->id : null)}}">
                                    <td>
                                        <select class ="form-control form-control-sm parking_composite" id="parking_composite" name="parking_composite[]">
                                            @if(!empty($unsoldParkings))
                                                @foreach ($unsoldParkings as $key => $unsoldParking)
                                                    <option value="{{$key}}" {{$key == $parking->parking_composite ? "selected" : null}}>{{$unsoldParking}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td>{{Form::text('parking_rate[]', old('parking_rate') ? old('parking_rate') : (!empty($parking->parking_rate) ? $parking->parking_rate : null),['class' => 'form-control form-control-sm parking_rate', 'min'=>'0', 'step'=>'0.01', 'required'] )}}</td>
                                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

    <hr class="bg-success">
    <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="total_value">Total  Apartment<br> Value <span class="text-danger">*</span></label>
                    {{Form::number('total_value', old('total_value') ? old('total_value') : (!empty($sell->total_value) ? $sell->total_value : 0),['class' => 'form-control', 'id' => 'total_value', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="booking_money">Booking Money<span class="text-danger">*</span></label>
                    {{Form::text('booking_money', old('booking_money') ? old('booking_money') : (!empty($sell->booking_money) ? $sell->booking_money : 0),['class' => 'form-control', 'id' => 'booking_money', 'min'=>'0','step'=>'0.01', 'placeholder' => '0.00', 'autocomplete'=>"off",'required'] )}}
                </div>
            </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="booking_money_date">Booking Date<span class="text-danger">*</span></label>
                {{Form::text('booking_money_date', old('booking_money_date') ? old('booking_money_date') : (!empty($sell->booking_money_date) ? $sell->booking_money_date : null),['class' => 'form-control', 'id' => 'booking_money_date', 'placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="downpayment">Downpayment<span class="text-danger">*</span></label>
                    {{Form::number('downpayment', old('downpayment') ? old('downpayment') : (!empty($sell->downpayment) ? $sell->downpayment : 0),['class' => 'form-control', 'id' => 'downpayment', 'min'=>'0', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="downpayment_date">Downpayment<br>Date<span class="text-danger">*</span></label>
                    {{Form::text('downpayment_date', old('downpayment_date') ? old('downpayment_date') : (!empty($sell->downpayment_date) ? $sell->downpayment_date : null),['class' => 'form-control', 'id' => 'downpayment_date', 'step'=>'0.01', 'placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off"] )}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="installment">Remaining<br>Amount<span class="text-danger">*</span></label>
                    {{Form::text('installment', old('installment') ? old('installment') : (!empty($sell->installment) ? $sell->installment : null),['class' => 'form-control', 'id' => 'installment', 'min'=>'0', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sell_date">Sold Date<span class="text-danger">*</span></label>
                    {{Form::text('sell_date', old('sell_date') ? old('sell_date') : (!empty($sell->sell_date) ? $sell->sell_date : null),['class' => 'form-control','id' => 'sell_date', 'placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off", 'required'])}}
                </div>
            </div>
            @php($currentUser = auth()->user())
            @if($currentUser->hasrole(['super-admin','admin','manager','authority']) || $currentUser->head)
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sell_by">Sold By<span class="text-danger">*</span></label>
                    {{Form::select('sell_by', $employees, old('sell_by') ? old('sell_by') : (!empty($sell->sell_by) ? $sell->sell_by : null),['class' => 'form-control','id' => 'sell_by', 'placeholder'=>'Select', 'autocomplete'=>"off", 'required'])}}
                </div>
            </div>
            @endif
        </div><!-- end row -->
    <!-- start Installment -->
    <hr class="bg-success">

    <div class="table-responsive">
        <table id="installmentListTable" class="table table-striped table-sm text-center table-bordered" >
            <thead>
                <tr>
                    <td class="bg-success" colspan="4"> <h5 class="text-center">Installment Information</h5></td>
                </tr>
                <tr>
                    <th>Installment No.</th>
                    <th>Date of Installment </th>
                    <th>Amount</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus addInstallment"></i></th>
                </tr>
            </thead>
            <tbody>

            @if(old('installment_date'))
                @foreach(old('installment_date') as $key=>$oldInstallmentDate)
                    <tr>
                        <td>
                            <input type="text" name="installment_no[]" value="{{old('installment_no')[$key]}}" class="form-control form-control-sm text-right installment_no" readonly tabindex="-1">
                        </td>
                        <td>
                            <input type="text" name="installment_date[]" value="{{old('installment_date')[$key]}}" class="form-control form-control-sm text-right installment_dates" placeholder="dd-mm-yyyy" required autocomplete="off">
                        </td>
                        <td>
                            <input type="number" name="installment_amount[]" value="{{old('installment_amount')[$key]}}" class="form-control form-control-sm text-right installment_amount" min="0" step="0.01" required autocomplete="off">
                        </td>
                        <td><i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($sell))
                    @foreach($sell->installmentList as $installmentList)
                        <tr>
                            <td>{{Form::number('installment_no[]', $installmentList->installment_no,['class' => 'form-control form-control-sm text-right installment_no', 'readonly','tabindex'=>'-1'] )}}</td>
                            <td>{{Form::text('installment_date[]', $installmentList->installment_date,['class' => 'form-control form-control-sm text-right installment_dates', 'id'=>'installment_date','placeholder'=>'dd-mm-yyyy','required','autocomplete'=>"off"] )}}</td>
                            <td>{{Form::number('installment_amount[]', $installmentList->installment_amount,['class' => 'form-control form-control-sm text-right installment_amount', 'min'=>'0', 'step'=>'0.01','required','autocomplete'=>"off"] )}}</td>
                            <td><i class="btn btn-primary btn-sm fa fa-plus addInstallment"></i><i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i></td>
                        </tr>
                    @endforeach
                @endif
            @endif

            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-right"> Total </td>
                <td>
                    {{Form::number('total_installment', old('total_installment') ? old('total_installment') :  null,['class' => 'form-control form-control-sm text-right', 'id' => 'total_installment', 'tabindex'=>"-1", 'autocomplete'=>"off",'required','readonly'] )}}
                </td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>


    <!-- end Installment -->

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}
    @endsection

    @section('script')
        <script>
            function addClient(){
                $('#clientTable tbody').append(
                    `<tr>
                        <td><input type="text" name="name[]" class="form-control form-control-sm name" placeholder="Type Client Name" required></td>
                        <td><input type="text" name="contact[]" class="form-control form-control-sm contact" readonly required></td>
                        <td><input  style="text-align: center;" type="text" name="client_id[]" class="form-control form-control-sm client_id" required readonly></td>
                        <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" type="button"><i class="fa fa-minus"></i></button></td>
                    </tr>`
                );
            }

            function addParking(){
                $('#parkingTable').append(
                    `<tr>
                          <td>
                            <select class ="form-control form-control-sm parking_composite"  name="parking_composite[]" required>
                                    <option></option>
                            </select>
                          </td>
                            <td><input type="text" name="parking_rate[]" class="form-control form-control-sm parking_rate" min="0" step='0.01'  autocomplete="off" required></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    <tr>`
                );
                $('#parking_no').val($('.parking_composite').length);
            }

            function addInstallment(){
                $('#installmentListTable tbody').append(
                    `<tr>
                        <td><input type="text" name="installment_no[]" value="" class="form-control form-control-sm installment_no text-right" readonly tabindex="-1"></td>
                        <td><input type="text" name="installment_date[]" value="" class="form-control form-control-sm installment_dates text-right" placeholder="dd-mm-yyyy"  autocomplete="off" required></td>
                        <td><input type="number" name="installment_amount[]" value="" class="form-control form-control-sm installment_amount text-right"  min='0' step='0.01' autocomplete="off" required ></td>
                        <td><i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i></td>
                    </tr>`
                );
                $('.installment_no').each(function(i){
                    $(this).val(i+1);
                });
                totalOperation();
            }

            function totalOperation(){
                var total = 0;
                if($(".installment_amount").length > 0){
                    $(".installment_amount").each(function(i, row){
                        var installment_amount = parseFloat($(row).val());
                        total += parseFloat(installment_amount);
                    })
                }
                $("#total_installment").val(total.toFixed(2));
            }
            //start adding parking

            var CSRF_TOKEN = "{{csrf_token()}}";
            $(function() {
                $('#booking_money_date,#downpayment_date,#sell_date,#hand_over_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

                @if($formType == 'create' && !old('client_id'))
                    addClient();
                @endif

// {{--              @if(!empty($sell) && $sell->nameTransfers->isEmpty())--}}
//                 $("#addClient").click(function(){
//                     addClient();
//                 });
// {{--              @endif--}}


                $(document).on('keyup', '.name', function(){
                    $(this).autocomplete({
                        minLength: 0,
                        source: function (request, response) {
                            $.ajax({
                                url: "{{route('clientAutoSuggest')}}",
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
                            $(this).val(ui.item.label);
                            $(this).closest('tr').find('.client_id').val(ui.item.value);
                            $(this).closest('tr').find('.contact').val(ui.item.contact);
                            return false;
                        }
                    })
                });

                $("#clientTable").on('click', '.deleteItem', function(){
                    $(this).closest('tr').remove();
                });

                $("#installmentListTable").on('click', '.deleteItem', function(){
                    $(this).closest('tr').remove();
                    $('.installment_no').each(function(i){
                        $(this).val(i+1);
                    });
                    totalOperation();
                });

                $("#parkingTable").on('click', '.deleteItem', function(){
                    $(this).closest('tr').remove();
                    $('#parking_no').val($('.parking_composite').length);
                    calculateParkingPrice();
                });

                $(document).on('keyup change', '.parking_rate', function(){
                    calculateParkingPrice();
                });

                $(document).on('click', '.addInstallment', function(){
                    addInstallment();
                });

                function calculateParkingPrice(){
                    // let size = $("#parking_no").val() > 0 ? parseFloat($("#parking_no").val()) : 0;
                    let totalAmount = 0;
                    $(".parking_rate").each(function(){
                        totalAmount += $(this).val() > 0 ? parseFloat($(this).val()) : 0;
                    });

                    $("#parking_price").val(totalAmount.toFixed(2));
                    grand_total_price();
                    calculateInstallment();
                }

                $(document).on('mouseenter', '.installment_dates', function(){
                    $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
                });

            });//document.ready

            function loadProjectApartment(){
                let dropdown = $('#apartment_id');
                let oldSelectedItem = "{{old('apartment_id') ? old('apartment_id') : null}}";
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Apartment </option>');
                dropdown.prop('selectedIndex', 0);
                const url = '{{url("loadProjectApartment")}}/' + $("#project_id").val();
                // Populate dropdown with list of provinces
                $.getJSON(url, function (items) {
                    $.each(items, function (key, entry) {
                        let select=(oldSelectedItem == entry.id) ? "selected" : null;
                        dropdown.append($(`<option ${select}></option>`).attr('value', entry.id).text(entry.name));
                    })
                });
            }

            function grand_total_price(){
                let total_value=0;
                $(".total_price").each(function(){
                    let currentValue = $(this).val() > 0 ? parseFloat($(this).val()) : 0;
                    total_value += parseFloat(currentValue);
                });
                $('#total_value').val((total_value).toFixed(2));
            }

            function calculateApartmentValue(){
                let size = $("#apartment_size").val() > 0 ? parseFloat($("#apartment_size").val()) : 0;
                let rate = $("#apartment_rate").val() > 0 ? parseFloat($("#apartment_rate").val()) : 0;
                let total = (size * rate).toFixed(2);
                $("#apartment_value").val(total);
                grand_total_price();
            }

            function calculateUtilityFees(){
                let size = $("#utility_no").val() > 0 ? parseFloat($("#utility_no").val()) : 0;
                let rate = $("#utility_price").val() > 0 ? parseFloat($("#utility_price").val()) : 0;
                let total = (size * rate).toFixed(2);
                $("#utility_fees").val(total);
                grand_total_price();
            }

            function calculateReserveFund(){
                let size = $("#reserve_no").val() > 0 ? parseFloat($("#reserve_no").val()) : 0;
                let rate = $("#reserve_rate").val() > 0 ? parseFloat($("#reserve_rate").val()) : 0;
                let total = (size * rate).toFixed(2);
                $("#reserve_fund").val(total);
                grand_total_price();
            }

            function calculateInstallment(){
                let total_value = $("#total_value").val() > 0 ? parseFloat($("#total_value").val()) : 0;
                let booking_money = $("#booking_money").val() > 0 ? parseFloat($("#booking_money").val()) : 0;
                let downpayment = $("#downpayment").val() > 0 ? parseFloat($("#downpayment").val()) : 0 ;
               $("#installment").val( total_value - (booking_money + downpayment));
            }

            $(document).on('keyup mousewheel', ".installment_amount", function(){
                totalOperation();
            });

            var CSRF_TOKEN = "{{csrf_token()}}";
            $(function(){
                @if(old())
                    loadProjectApartment();
                @endif
                totalOperation();

                $( "#project_name").autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('projectAutoSuggest')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#project_name').val(ui.item.label);
                        $('#project_id').val(ui.item.value);
                        return false;
                    }
                }).on('change', function(){
                    loadProjectApartment();
                });

                $("#size, #rate").on('change keyup', function(){
                    calculateAmount();
                    calculateInstallment();
                });

                $(document).on('change keyup', '#apartment_size, #apartment_rate', function(){
                    calculateApartmentValue();
                    calculateInstallment();
                });

                $(document).on('change keyup', '#utility_no, #utility_price', function(){
                    calculateUtilityFees();
                    calculateInstallment();
                });

                $(document).on('change keyup', '#reserve_no, #reserve_rate', function(){
                    calculateReserveFund();
                    calculateInstallment();
                });

                $(document).on('change keyup', '#others', function(){
                    grand_total_price();
                    calculateInstallment();
                });

                $(document).on('change keyup', '#booking_money, #downpayment, #installment', function(){
                    grand_total_price();
                    calculateInstallment();
                });

                $(document).on('click', '.parking_composite', function(){
                    let project_id = $("#project_id").val();
                    if(!$(this).val()){
                        let dropdown = $(this);
                        dropdown.empty();
                        dropdown.prop('selectedIndex', 0);
                        const url = '{{url("loadProjectUnsoldParkings")}}/' + project_id;
                        // Populate dropdown with list of provinces
                        $.getJSON(url, function (items) {
                            $.each(items, function (key, entry) {
                                dropdown.append($('<option></option>').attr('value', key).text(entry));
                            })
                        });
                    }
                });

            });//document.ready
        </script>
@endsection
