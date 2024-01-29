@extends('layouts.backend-layout')
@section('title', 'Letter')

@section('breadcrumb-title')
        Make Letter
@endsection

@section('breadcrumb-button')
    <a href="{{ url(route("csd.letter.index")) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

{{-- @section('content-grid', null)  --}}

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "csd/letter/$letter->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => 'csd/letter','method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="letter_title">Letter Title<span class="text-danger">*</span></label>
                    {{Form::text('letter_title', old('letter_title') ? old('letter_title') : (!empty($letter->letter_title) ? $letter->letter_title : null),['class' => 'form-control letter_title','id' => 'letter_title','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="letter_date">Date<span class="text-danger">*</span></label>
                    {{Form::text('letter_date', old('letter_date') ? old('letter_date') : (!empty($letter->letter_date) ? $letter->letter_date : null),['class' => 'form-control letter_date','id' => 'letter_date','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($letter->id) ? $letter->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($letter->id) ? $letter->project->id : null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
        </div><br><br><br>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <h6>To</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-2 col-md-2">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('address_word_one', old('address_word_one') ? old('address_word_one') : (!empty($letter->address_word_one) ? $letter->address_word_one : null),['class' => 'form-control address_word_one','id' => 'address_word_one','autocomplete'=>"off","required", 'placeholder'=>"Mr/Mrs",])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <input type="hidden" name="apartment_id" class="apartment_id" >
                    {{Form::select('sell_id', $clients, old('sell_id') ? old('sell_id') : (!empty($letter->sell_id) ? $client->client->name : null),['class' => 'form-control','id' => 'sell_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::textarea('client_address', old('client_address') ? old('client_address') : (!empty($client->client->present_address) ? $client->client->present_address : null),['class' => 'form-control client_address', 'rows' => '2', 'id' => 'client_address','autocomplete'=>"off","required", 'readonly'])}}
                </div>
            </div>
        </div><br>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-1 col-md-1">
                <div class="input-group input-group-sm input-group-primary">
                    <h6 class="form-control " style="border: none">Subject: </h6>
                </div>
            </div>
            <div class="col-xl-10 col-md-10">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('letter_subject', old('letter_subject') ? old('letter_subject') : (!empty($letter->letter_subject) ? $letter->letter_subject : null),['class' => 'form-control letter_subject','id' => 'letter_subject','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div><br><br><br>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-1 col-md-1">
                <div class="input-group input-group-sm input-group-primary">
                    <h6 class="form-control" style="border: none">Dear</h6>
                </div>
            </div>
            <div class="col-xl-2 col-md-2">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('address_word_two', 'Sir/Madam',['class' => 'form-control address_word_two','id' => 'address_word_two','autocomplete'=>"off","required", 'placeholder'=>"Sir/Madam",'readonly'])}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-10 col-md-10">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::textarea('letter_body', old('letter_body') ? old('letter_body') : (!empty($letter->id) ? $letter->letter_body : null),['class' => 'form-control letter_body','id' => 'editor1','autocomplete'=>"off","required",])}}
                </div>
            </div>
        </div><br><br><br><br>
        <div class="row">
            <div class="col-xl-2 col-md-2"></div>
            <div class="col-xl-4 col-md-4">
                <table>
                    <tr>
                        <td>
                            <span>---------------------------------</span><br>
                            <span>Manager</span><br>
                            <span>Customer Service Department</span><br>
                            <span>{!! htmlspecialchars(config('company_info.company_fullname')) !!}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div><br><br><br>

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
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/ckeditor/ckeditor-custom.js')}}"></script>

    <script>


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {

            // function for auto suggest projects
            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('csd.projectAutoSuggest')}}",
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
                loadSoldClientsWithApartment();
            });

            // Function for getting sold appartment
            function loadSoldClientsWithApartment() {
                const project_id = $("#project_id").val();
                let sell_id = @json(old('sell_id', $letter->sell_id ?? ''));

                if (project_id != '') {
                    let dropdown = $('#sell_id');
                    dropdown.empty();
                    dropdown.append('<option selected="true" disabled>Select Client </option>');
                    dropdown.prop('selectedIndex', 0);

                    const url = '{{ url("loadSoldClientsWithApartment") }}/' + project_id;
                    $.getJSON(url, function(items) {
                        $.each(items, function(key, sellDetails) {
                            console.log(sellDetails);
                            let select = (sell_id === sellDetails.sell_client.client_id) ? "selected" : '';
                                $('.apartment_id').val(sell_id);
                            let options =
                                `<option value="${sellDetails.sell_client.client.id}" ${select}>
                                    ${sellDetails.sell_client.client.name} [Apartment : ${sellDetails.apartment.name}]
                                </option>`;
                            dropdown.append(options);
                        })
                    });
                }
            }



            // function for getting client address for specific apartment

            function getAddressByClient() {
                let sell_id = $("#sell_id").val();
                let url = '{{ url("csd/getAddressByClient") }}/' + sell_id;
                fetch(url)
                .then((resp) => resp.json())
                .then(function(Address) {
                    $('#client_address').val(Address.present_address);
                })
            }

            $(document).on('change', '#sell_id', function() {
                getAddressByClient();
            });



            @if ($formType == "edit")
                $(document).ready(function() {
                    loadSoldClientsWithApartment();
                });
            @endif

            $(document).on('mouseenter', '.letter_date', function() {
                $(this).datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });
        });
    </script>
@endsection
