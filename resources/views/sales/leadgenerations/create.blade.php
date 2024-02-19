@extends('layouts.backend-layout')
@section('title', 'Lead Generations')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Lead Generation
    @else
        New Lead Generation
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('leadgenerations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if ($formType == 'edit')
        {!! Form::open([
            'url' => "leadgenerations/$leadgeneration->id",
            'encType' => 'multipart/form-data',
            'method' => 'PUT',
            'name' => 'leadForm',
            'id' => 'leadForm',
            'class' => 'custom-form',
        ]) !!}
        <input type="hidden" name="id"
            value="{{ old('id') ? old('id') : (!empty($leadgeneration->id) ? $leadgeneration->id : null) }}">
    @else
        {!! Form::open([
            'url' => 'leadgenerations',
            'method' => 'POST',
            'encType' => 'multipart/form-data',
            'class' => 'custom-form',
            'name' => 'leadForm',
            'id' => 'leadForm',
        ]) !!}
    @endif
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Prospect Name<span class="text-danger">*</span></label>
                {{ Form::text('name', old('name') ? old('name') : (!empty($leadgeneration->name) ? $leadgeneration->name : null), ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off', 'required']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message"> </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="email">Prospect Email</label>
                {{ Form::email('email', old('email') ? old('email') : (!empty($leadgeneration->email) ? $leadgeneration->email : null), ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="profession">Profession</label>
                {{ Form::text('profession', old('profession') ? old('profession') : (!empty($leadgeneration->profession) ? $leadgeneration->profession : null), ['class' => 'form-control', 'id' => 'profession', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="contact">Contact <span class="text-danger">*</span></label>
                {{ Form::select('country_code', $codes, old('country_code') ? old('country_code') : (!empty($leadgeneration->country_code) ? $leadgeneration->country_code : '+880'), ['class' => 'country_code', 'style' => 'width:70px', 'id' => 'country_code', 'autocomplete' => 'off', 'required']) }}
                {{ Form::number('contact', old('contact') ? old('contact') : (!empty($leadgeneration->contact) ? $leadgeneration->contact : null), ['class' => 'form-control', 'id' => 'contact', 'autocomplete' => 'off', 'required', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="contact_message"> </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="contact_alternate">Contact (2)</label>
                {{ Form::select('country_code_two', $codes, old('country_code_two') ? old('country_code_two') : (!empty($leadgeneration->country_code_two) ? $leadgeneration->country_code_two : '+880'), ['class' => 'country_code', 'style' => 'width:70px', 'id' => 'country_code', 'autocomplete' => 'off', 'required']) }}
                {{ Form::number('contact_alternate', old('contact_alternate') ? old('contact_alternate') : (!empty($leadgeneration->contact_alternate) ? $leadgeneration->contact_alternate : null), ['class' => 'form-control', 'id' => 'contact_alternate', 'autocomplete' => 'off', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="contact_message"> </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="contact_alternate">Contact (3)</label>
                {{ Form::select('country_code_three', $codes, old('country_code_three') ? old('country_code_three') : (!empty($leadgeneration->country_code_three) ? $leadgeneration->country_code_three : '+880'), ['class' => 'country_code', 'style' => 'width:70px', 'id' => 'country_code', 'autocomplete' => 'off', 'required']) }}
                {{ Form::number('contact_alternate_three', old('contact_alternate_three') ? old('contact_alternate_three') : (!empty($leadgeneration->contact_alternate_three) ? $leadgeneration->contact_alternate_three : null), ['class' => 'form-control', 'id' => 'contact_alternate_three', 'autocomplete' => 'off', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="contact_message"> </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="company_name">Company Name</label>
                {{ Form::text('company_name', old('company_name') ? old('company_name') : (!empty($leadgeneration->company_name) ? $leadgeneration->company_name : null), ['class' => 'form-control', 'id' => 'company_name', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="nationality">Country</label>
                {{ Form::text('nationality', old('nationality') ? old('nationality') : (!empty($leadgeneration->nationality) ? $leadgeneration->nationality : null), ['class' => 'form-control', 'id' => 'nationality', 'autocomplete' => 'off', 'placeholder' => 'Enter Country Name']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="spouse_name">Spouse Name</label>
                {{ Form::text('spouse_name', old('spouse_name') ? old('spouse_name') : (!empty($leadgeneration->spouse_name) ? $leadgeneration->spouse_name : null), ['class' => 'form-control', 'id' => 'spouse_name', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="spouse_contact">Spouse Number</label>
                {{ Form::select('spouse_code', $codes, old('spouse_code') ? old('spouse_code') : (!empty($leadgeneration->spouse_code) ? $leadgeneration->spouse_code : '+880'), ['class' => 'country_code', 'style' => 'width:70px', 'id' => 'country_code', 'autocomplete' => 'off', 'required']) }}
                {{ Form::number('spouse_contact', old('spouse_contact') ? old('spouse_contact') : (!empty($leadgeneration->spouse_contact) ? $leadgeneration->spouse_contact : null), ['class' => 'form-control', 'id' => 'spouse_contact', 'autocomplete' => 'off', 'onkeypress' => 'return /[0-9a-zA-Z]/i.test(event.key)']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="contact_message"> </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="offer_price">Offer Price</label>
                {{ Form::number('offer_price', old('offer_price') ? old('offer_price') : (!empty($leadgeneration->offer_price) ? $leadgeneration->offer_price : null), ['class' => 'form-control', 'id' => 'offer_price', 'autocomplete' => 'off', 'step' => 'any']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="">Company Price</label>
                {{ Form::number('company_price', old('company_price') ? old('company_price') : (!empty($leadgeneration->company_price) ? $leadgeneration->company_price : null), ['class' => 'form-control', 'id' => 'company_price', 'autocomplete' => 'off', 'step' => 'any']) }}
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="present_address">Present Address</label>
                {{ Form::textarea('present_address', old('present_address') ? old('present_address') : (!empty($leadgeneration->present_address) ? $leadgeneration->present_address : null), ['class' => 'form-control', 'id' => 'present_address', 'autocomplete' => 'off', 'rows' => 2]) }}
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="permanent_address">Permanent<br> Address </label>
                {{ Form::textarea('permanent_address', old('permanent_address') ? old('permanent_address') : (!empty($leadgeneration->permanent_address) ? $leadgeneration->permanent_address : null), ['class' => 'form-control', 'id' => 'permanent_address', 'autocomplete' => 'off', 'rows' => 2]) }}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="customer_offer_details">Customer <br> Offer Details</label>
                {{ Form::textarea('customer_offer_details', old('customer_offer_details') ? old('customer_offer_details') : (!empty($leadgeneration->customer_offer_details) ? $leadgeneration->customer_offer_details : null), ['class' => 'form-control', 'id' => 'customer_offer_details', 'autocomplete' => 'off', 'rows' => 2]) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="business_card">Business Card</label>
                {{ Form::file('business_card', ['class' => 'form-control', 'id' => 'business_card', 'autocomplete' => 'off']) }}
            </div>
        </div>

    </div> <!-- end row -->

    <hr class="bg-success">

    <div class="row">
        {{--        <div class="col-xl-4 col-md-6"> --}}
        {{--            <div class="input-group input-group-sm input-group-primary"> --}}
        {{--                <label class="input-group-addon" for="lead_date">Lead Date<span class="text-danger">*</span></label> --}}
        {{--                {{Form::text('lead_date', old('lead_date') ? old('lead_date') : (!empty($leadgeneration->lead_date) ? $leadgeneration->lead_date : now()->format('d-m-Y')),['class' => 'form-control','id' => 'lead_date', 'autocomplete'=>"off",'required','readonly'])}} --}}
        {{--            </div> --}}
        {{--        </div> --}}
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="lead_stage">Lead Stage<span class="text-danger">*</span></label>
                {{ Form::select('lead_stage', $lead_stages, old('lead_stage') ? old('lead_stage') : (!empty($leadgeneration->lead_stage) ? $leadgeneration->lead_stage : null), ['class' => 'form-control', 'id' => 'lead_stage', 'placeholder' => 'Select Stage', 'autocomplete' => 'off', 'required']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message"> </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_type">Source Type<span class="text-danger">*</span></label>
                {{ Form::text('source_type', old('source_type') ? old('source_type') : (!empty($leadgeneration->source_type) ? $leadgeneration->source_type : null), ['class' => 'form-control', 'id' => 'source_type', 'autocomplete' => 'off', 'required', 'placeholder' => 'Enter Source Type', 'list' => 'source_list']) }}
                <datalist id="source_list">
                    <option value="Telemarketing"></option>
                    <option value="Hotline"></option>
                    <option value="Digital Marketing"></option>
                    <option value="Paper Add"></option>
                    <option value="Internal Reference"></option>
                    <option value="Direct Sells Initiative"></option>
                    <option value="Walking Customer (Head Office)"></option>
                    <option value="Walking Customer (Project)"></option>
                    <option value="Management"></option>
                    <option value="Existing Client"></option>
                    <option value="Others"></option>
                </datalist>
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="projects">Projects<span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($leadgeneration) ? $leadgeneration->apartment->project->name : null), ['class' => 'form-control', 'id' => 'project_name', 'autocomplete' => 'off']) }}
                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($leadgeneration) ? $leadgeneration->apartment->project->id : null), ['class' => 'form-control', 'id' => 'project_id', 'autocomplete' => 'off']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="apartment_id">Apartment/Unit<span
                        class="text-danger">*</span></label>
                {{ Form::select('apartment_id', $apartments, old('apartment_id') ? old('apartment_id') : (!empty($leadgeneration->apartment_id) ? $leadgeneration->apartment_id : null), ['class' => 'form-control', 'id' => 'apartment_id', 'autocomplete' => 'off', 'required']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="attachment">Attachment</label>
                {{ Form::file('attachment', ['class' => 'form-control', 'id' => 'attachment', 'autocomplete' => 'off']) }}
            </div>

        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="offer_details">{{ config('company_info.company_shortname') }} Offers Details</label>
                {{ Form::textarea('offer_details', old('offer_details') ? old('offer_details') : (!empty($leadgeneration->offer_details) ? $leadgeneration->offer_details : null), ['class' => 'form-control', 'id' => 'offer_details', 'autocomplete' => 'off', 'rows' => 2]) }}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{ Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($leadgeneration->remarks) ? $leadgeneration->remarks : null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => 2, 'autocomplete' => 'off']) }}
            </div>
            <input type="hidden" id="validation" value="false" />
        </div>
    </div> <!-- end row -->

    @if ($formType != 'edit')

    <hr class="bg-success">
    <div class="row">

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="leadgeneration_name">Prospect Name<span
                        class="text-danger">*</span></label>
                {{ Form::text('leadgeneration_name', old('leadgeneration_name') ? old('leadgeneration_name') : (!empty($leadGeneration) ? $leadGeneration->name : null), ['class' => 'form-control', 'id' => 'leadgeneration_name', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Activity Date<span class="text-danger">*</span></label>
                {{ Form::text('date', old('date') ? old('date') : (!empty($followup->date) ? $followup->date : date('d-m-Y', strtotime(now()))), ['class' => 'form-control', 'id' => '', 'autocomplete' => 'off', 'required', 'placeholder' => 'dd-mm-yyyy', 'readonly']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Next<br>Followup Date<span
                        class="text-danger">*</span></label>
                {{ Form::text('next_followup_date', old('next_followup_date') ? old('next_followup_date') : (!empty($followup->next_followup_date) ? $followup->next_followup_date : null), ['class' => 'form-control', 'id' => 'next_followup_date', 'autocomplete' => 'off', 'required', 'placeholder' => 'dd-mm-yyyy']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-4 col-md-6">

            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="time_from">Time From<span class="text-danger">*</span></label>
                {{ Form::time('time_from', old('time_from') ? old('time_from') : (!empty($followup->time_from) ? $followup->time_from : date('H:i', strtotime(now()))), ['class' => 'form-control', 'id' => 'time_from', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="time_till">Time Till <span class="text-danger">*</span></label>
                {{ Form::time('time_till', old('time_till') ? old('time_till') : (!empty($followup->time_till) ? $followup->time_till : null), ['class' => 'form-control', 'id' => 'time_till', 'autocomplete' => 'off', 'required']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="activity_type">Activity Type<span
                        class="text-danger">*</span></label>
                {{ Form::text('activity_type', old('activity_type') ? old('activity_type') : (!empty($followup->activity_type) ? $followup->activity_type : null), ['class' => 'form-control', 'id' => 'activity_type', 'autocomplete' => 'off', 'required', 'placeholder' => 'Enter Activity Type', 'list' => 'activity_type_list']) }}
                <datalist id="activity_type_list">
                    <option value="Physical Visit"></option>
                    <option value="Telephone Conversation"></option>
                    <option value="Jumairah Office Visit"></option>
                    <option value="Project Visit"></option>
                </datalist>
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reason">Activity For<span class="text-danger">*</span></label>
                {{ Form::text('reason', old('reason') ? old('reason') : (!empty($followup->reason) ? $followup->reason : null), ['class' => 'form-control', 'id' => 'reason', 'autocomplete' => 'off', 'required']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="feedback">Prospect <br>Feedback <span class="text-danger"
                        style="margin-top: 12px;">*</span></label>
                {{ Form::textarea('feedback', old('feedback') ? old('feedback') : (!empty($followup->feedback) ? $followup->feedback : null), ['class' => 'form-control', 'id' => 'feedback', 'rows' => '2', 'autocomplete' => 'off', 'required']) }}
            </div>
            <p style="font-size: 11px; color: red; text-align: right; padding: 0; margin: 0" class="required_message">
            </p>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{ Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($followup->remarks) ? $followup->remarks : null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => '2', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div> <!-- end row -->
    @endif
    <hr>
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2" type="button" onClick="checkValidation()"
                    id="submitBtn">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}


@endsection
@section('script')
    <script>
        function loadProjectApartment() {
            var dropdown = $('#apartment_id');
            dropdown.empty();
            // dropdown.append('<option selected="true" disabled>Select Apartment </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{ url('loadProjectApartment') }}/' + $("#project_id").val();
            console.log($("#project_id").val());
            // Populate dropdown with list of provinces
            $.getJSON(url, function(items) {
                $.each(items, function(key, entry) {
                    console.log(entry);
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }

        function contactMessages(thisVal) {
            let contact = $(thisVal).val();
            let code = $(thisVal).parent().find(".country_code").val();
            const url = '{{ url('contactMessage') }}/' + contact + '/' + code;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(data) {
                    // console.log();
                    if (data != '') {
                        $(thisVal).parent().parent().find(".contact_message").text(data)
                        $('#validation').val('true')
                    } else {
                        $(thisVal).parent().parent().find(".contact_message").text('')
                        $('#validation').val('false')
                    }
                })
                .catch((error) => {
                    $(thisVal).parent().parent().find(".contact_message").text('')
                    $('#validation').val('false')
                });
        }

        function checkValidation() {
            let validation = $('#validation').val();
            let contact = $('#contact').val();
            let contact_alternate = $('#contact_alternate').val();
            let contact_alternate_three = $('#contact_alternate_three').val();
            let spouse_contact = $('#spouse_contact').val();
            let lead_stage = $('#lead_stage').val();
            let source_type = $('#source_type').val();
            let name = $('#name').val();
            let project_name = $('#project_name').val();
            let apartment_id = $('#apartment_id').val();
            let date = $('#date').val();
            let next_followup_date = $('#next_followup_date').val();
            let time_from = $('#time_from').val();
            let time_till = $('#time_till').val();
            let activity_type = $('#activity_type').val();
            let reason = $('#reason').val();
            let feedback = $('#feedback').val();



            if (name.length == 0) {
                $('#name').parent().parent().find(".required_message").text("Prospect Name is Required");
                // alert('Contact is Required');
                return false;
            } else {
                $('#name').parent().parent().find(".required_message").text("");
            }

            if (contact.length == 0) {
                $('#contact').parent().parent().find(".contact_message").text("Contact is Required");
                // alert('Contact is Required');
                return false;
            } else {
                $('#contact').parent().parent().find(".contact_message").text("");
            }

            if (lead_stage.length == 0) {
                $('#lead_stage').parent().parent().find(".required_message").text("Lead Stage is Required");
                return false;
            } else {
                $('#lead_stage').parent().parent().find(".required_message").text("");
            }

            if (source_type.length == 0) {
                $('#source_type').parent().parent().find(".required_message").text("Source Type is Required");
                return false;
            } else {
                $('#source_type').parent().parent().find(".required_message").text("");
            }

            if (project_name.length == 0) {
                $('#project_name').parent().parent().find(".required_message").text("Project Name is Required");
                return false;
            } else {
                $('#project_name').parent().parent().find(".required_message").text("");
            }

            if (apartment_id.length == 0) {
                $('#apartment_id').parent().parent().find(".required_message").text("Apartment  is Required");
                return false;
            } else {
                $('#apartment_id').parent().parent().find(".required_message").text("");
            }

            if (activity_type == '') {
                $('#activity_type').parent().parent().find(".required_message").text("Activity Type is Required");
                return false;
            } else {
                $('#activity_type').parent().parent().find(".required_message").text("");
            }

            if (reason == '') {
                $('#reason').parent().parent().find(".required_message").text("Reason is Required");
                return false;
            } else {
                $('#reason').parent().parent().find(".required_message").text("");
            }

            if (feedback == '') {
                $('#feedback').parent().parent().find(".required_message").text("Feedback is Required");
                return false;
            } else {
                $('#feedback').parent().parent().find(".required_message").text("");
            }

            if (date == '') {
                $('#date').parent().parent().find(".required_message").text("Date is Required");
                return false;
            } else {
                $('#date').parent().parent().find(".required_message").text("");
            }

            if (next_followup_date == '') {
                $('#next_followup_date').parent().parent().find(".required_message").text("Next Followup Date is Required");
                return false;
            } else {
                $('#next_followup_date').parent().parent().find(".required_message").text("");
            }

            if (time_from == '') {
                $('#time_from').parent().parent().find(".required_message").text("Time From is Required");
                return false;
            } else {
                $('#time_from').parent().parent().find(".required_message").text("");
            }

            if (time_till == '') {
                $('#time_till').parent().parent().find(".required_message").text("Time Till is Required");
                return false;
            } else {
                $('#time_till').parent().parent().find(".required_message").text("");
            }

            if (contact != '' && contact == contact_alternate || contact == contact_alternate_three || contact ==
                spouse_contact) {
                alert('Please enter different contact number');
                return false;
            } else if (contact_alternate != '' && (contact_alternate == contact_alternate_three || contact_alternate ==
                    spouse_contact)) {

                alert('Please enter different contact (2) number');
                return false;
            } else if (contact_alternate_three != '' && contact_alternate_three == spouse_contact) {
                alert('Please enter different contact (3) or Spouse number');
                return false;
            }

            if (validation == 'true') {
                alert('Please Add Another Number');
                return false;
            } else {
                $('form[name=leadForm]').submit();
            }
        }

        $("#name").on('change', function() {
            $("#name").parent().parent().find(".required_message").text("");
        });
        $("#lead_stage").on('change', function() {
            $("#lead_stage").parent().parent().find(".required_message").text("");
        });
        $("#source_type").on('change', function() {
            $("#source_type").parent().parent().find(".required_message").text("");
        });
        $("#project_name").on('change', function() {
            $("#project_name").parent().parent().find(".required_message").text("");
        });
        $("#apartment_id").on('change', function() {
            $("#apartment_id").parent().parent().find(".required_message").text("");
        });

        $("#contact").on('change', function() {
            contactMessages(this);
        });

        $("#contact_alternate").on('change', function() {
            contactMessages(this);
        });

        $("#contact_alternate_three").on('change', function() {
            contactMessages(this);
        });

        $("#spouse_contact").on('change', function() {
            contactMessages(this);
        });

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            // loadProjectApartment();
            $('#lead_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
            $("#project_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('projectAutoSuggest') }}",
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
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    loadProjectApartment();
                    return false;
                }
            });

            $("#nationality").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('countryAutoSuggest') }}",
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
                    $('#nationality').val(ui.item.label); // display the selected text
                    return false;
                }
            });

        });

        $('#name').on('input', function() {
            var name = $('#name').val();
            $('#leadgeneration_name').val(name);
        });

        $(function() {
            $('#date, #next_followup_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

        });
    </script>
@endsection
