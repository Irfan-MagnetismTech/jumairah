@extends('layouts.backend-layout')
@section('title', 'Clients')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Client
    @else
        Entry Client Information
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('clients') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "clients/$client->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "clients",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="lead_id">Client Name<span class="text-danger">*</span></label>
                {{Form::text('name', old('name') ? old('name') : (!empty($client) ? $client->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
                {{Form::hidden('lead_id', old('lead_id') ? old('lead_id') : (!empty($client->lead_id) ? $client->lead_id : null),['class' => 'form-control','id' => 'lead_id', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="contact">Contact<span class="text-danger">*</span></label>
                {{Form::text('contact', old('contact') ? old('contact') : (!empty($client->contact) ? $client->contact : null),['class' => 'form-control', 'id' => 'contact', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="contact_alternate">Contact optional<span class="text-danger">*</span></label>
                {{Form::text('contact_alternate', old('contact_alternate') ? old('contact_alternate') : (!empty($client->contact_alternate) ? $client->contact_alternate : null),['class' => 'form-control', 'id' => 'contact_alternate', 'autocomplete'=>"off"] )}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="email">Email<span class="text-danger">*</span></label>
                {{Form::email('email', old('email') ? old('email') : (!empty($client->email) ? $client->email : null),['class' => 'form-control', 'id' => 'email', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="company_name">Company Name</label>
                {{Form::text('company_name', old('company_name') ? old('company_name') : (!empty($client->company_name) ? $client->company_name : null),['class' => 'form-control','id' => 'company_name', 'autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="nationality">Country <span class="text-danger">*</span></label>
                {{Form::text('nationality', old('nationality') ? old('nationality') : (!empty($client->nationality) ?$client->nationality : null),['class' => 'form-control', 'id' => 'nationality',  'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="profession">Profession <span class="text-danger">*</span></label>
                {{Form::text('profession', old('profession') ? old('profession') : (!empty($client->profession) ? $client->profession : null),['class' => 'form-control', 'id' => 'profession',  'autocomplete'=>"off",'required'] )}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="spouse_name">Spouse Name</label>
                {{Form::text('spouse_name', old('spouse_name') ? old('spouse_name') : (!empty($client->spouse_name) ? $client->spouse_name : null),['class' => 'form-control', 'id' => 'spouse_name', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="spouse_contact">Spouse Contact</label>
                {{Form::text('spouse_contact', old('spouse_contact') ? old('spouse_contact') : (!empty($client->spouse_contact) ? $client->spouse_contact : null),['class' => 'form-control', 'id' => 'spouse_contact', 'autocomplete'=>"off"] )}}
            </div>
        </div>

        <div class="col-xl-6 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="present_address">Present <br>Address <span class="text-danger">*</span></label>
                {{Form::textarea('present_address', old('present_address') ? old('present_address') : (!empty($client->present_address) ? $client->present_address : null),['class' => 'form-control', 'id' => 'present_address', 'rows'=>'1','autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="permanent_address">Permanent <br>Address<span class="text-danger">*</span></label>
                {{Form::textarea('permanent_address', old('permanent_address') ? old('permanent_address') : (!empty($client->permanent_address) ? $client->permanent_address : null),['class' => 'form-control', 'id' => 'permanent_address', 'rows'=>'1','autocomplete'=>"off",'required'] )}}
            </div>
        </div>

    </div>
    <hr class="bg-success">
     <div  class="row">
         <div class="col-xl-4 col-md-6">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="father_name">Father's Name<span class="text-danger">*</span></label>
                 {{Form::text('father_name', old('father_name') ? old('father_name') : (!empty($client->father_name) ? $client->father_name : null),['class' => 'form-control','id' => 'father_name', 'autocomplete'=>"off",'required'])}}
             </div>
         </div>
         <div class="col-xl-4 col-md-6">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="mother_name">Mother's Name<span class="text-danger">*</span></label>
                 {{Form::text('mother_name', old('mother_name') ? old('mother_name') : (!empty($client->mother_name) ? $client->mother_name: null),['class' => 'form-control','id' => 'mother_name', 'autocomplete'=>"off",'required'])}}
             </div>
         </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="dob">Date of Birth<span class="text-danger">*</span></label>
                {{Form::text('dob', old('dob') ? old('dob') : (!empty($client->dob) ? $client->dob : null),['class' => 'form-control', 'id' => 'dob','placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="marriage_anniversary">Marriage<br>Anniversary</label>
                {{Form::text('marriage_anniversary', old('marriage_anniversary') ? old('marriage_anniversary') : (!empty($client->marriage_anniversary) ? $client->marriage_anniversary : null),['class' => 'form-control','placeholder'=>'dd-mm-yyyy', 'id' => 'marriage_anniversary', 'autocomplete'=>"off"] )}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="nid">NID</label>
                {{Form::text('nid', old('nid') ? old('nid') : (!empty($client->nid) ? $client->nid : null),['class' => 'form-control', 'id' => 'nid', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="tin">TIN</label>
                {{Form::text('tin', old('tin') ? old('tin') : (!empty($client->tin) ? $client->tin : null),['class' => 'form-control', 'id' => 'tin', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="picture">Client Picture</label>
                {{Form::file('picture',['class' => 'form-control','id' => 'picture','accept'=>"image/*","onchange"=>"document.getElementById('picture').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($client) && $client->picture)
                <p class="text-right mt-0 pt-0"><a href="{{ asset("storage/$client->picture") }}" target="_blank">See Current Picture</a></p>
            @endif
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="client_profile">Client Profile</label>
                {{Form::file('client_profile',['class' => 'form-control','id' => 'client_profile',"onchange"=>"document.getElementById('client_profile').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($client) && $client->client_profile)
                <p class="text-right mt-0 pt-0"><a href="{{ asset("storage/$client->client_profile") }}" target="_blank">See Current Profile</a></p>
            @endif
        </div>

    </div>

    <hr class="bg-success">
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="auth_name">Authorized Name</label>
                {{Form::text('auth_name', old('auth_name') ? old('auth_name') : (!empty($client->auth_name) ? $client->auth_name : null),['class' => 'form-control', 'id' => 'auth_name', 'autocomplete'=>"off"] )}}
            </div>

        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="auth_address">Authorized<br>Address</label>
                {{Form::text('auth_address', old('auth_address') ? old('auth_address') : (!empty($client->auth_address) ? $client->auth_address : null),['class' => 'form-control', 'id' => 'auth_address', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="auth_contact">Authorized<br>Contact</label>
                {{Form::text('auth_contact', old('auth_contact') ? old('auth_contact') : (!empty($client->auth_contact) ? $client->auth_contact : null),['class' => 'form-control', 'id' => 'auth_contact', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="auth_email">Authorized Email</label>
                {{Form::email('auth_email', old('auth_email') ? old('auth_email') : (!empty($client->auth_email) ? $client->auth_email : null),['class' => 'form-control', 'id' => 'auth_email', 'min'=>'0', 'autocomplete'=>"off"] )}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="auth_picture">Authorized Picture</label>
                {{Form::file('auth_picture',['class' => 'form-control','id' => 'auth_picture','accept'=>"image/*","onchange"=>"document.getElementById('auth_picture').src = window.URL.createObjectURL(this.files[0])"])}}
            </div>
            @if(!empty($client) && $client->auth_picture)
                <p class="text-right mt-0 pt-0"><a href="{{ asset("storage/$client->auth_picture") }}" target="_blank">See Current Authrized Picture</a></p>
            @endif
        </div>
    </div>

    <hr class="bg-success">
    <div class="section">
        <div class="bg-light my-2 p-1">
            <h5 class="text-center"> Nominee Information</h5>
        </div>
        <div class="table-responsive">
            <table id="nomineeTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Name<span class="text-danger">*</span></th>
                    <th>Age<span class="text-danger">*</span></th>
                    <th>Relation<span class="text-danger">*</span></th>
                    <th>Address<span class="text-danger">*</span></th>
                    <th>Nominee Picture</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addNominee()"> </i></th>
                </tr>
                </thead>
                <tbody>

                @if(old('nominee_name'))
                    @foreach(old('nominee_name') as $key => $oldItem)
                        <tr>
                            <td><input type="text" name="nominee_name[]" value="{{old('nominee_name')[$key]}}" class="form-control form-control-sm" required></td>
                            <td><input type="text" name="age[]" value="{{old('age')[$key]}}" class="form-control form-control-sm" min="0" step="1" max="100" required></td>
                            <td><input type="text" name="relation[]" value="{{old('relation')[$key]}}" class="form-control form-control-sm" required></td>
                            <td><textarea name="address[]" class="form-control form-control-sm" rows="1" required>{{old('address')[$key]}}</textarea></td>
                            <td><input type="file" name="nominee_picture[]" value="{{old('nominee_picture')}}" class="form-control form-control-sm"  accept="image/*" required></td>
                            {{Form::hidden('nominee_old_picture[]', old('nominee_picture') ? old('nominee_picture') : null,['class' => 'form-control form-control-sm'] )}}

                            <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if(!empty($client))
                        @foreach($client->clientNominee as $clientNominee)
                            <tr>
                                <input type="hidden" name="id" value="{{(!empty($clientNominee->id) ? $clientNominee->id : null)}}">
                                <td> {{Form::text('nominee_name[]',old('nominee_name') ? old('nominee_name') : (!empty($clientNominee->nominee_name) ? $clientNominee->nominee_name : null),  ['class' => 'form-control form-control-sm',  'required' ])}}</td>
                                <td>{{Form::number('age[]', old('age') ? old('age') : (!empty($clientNominee->age) ? $clientNominee->age : null),['class' => 'form-control form-control-sm', 'min'=>'0', 'step'=>'1','max'=>'100', 'required'] )}}</td>
                                <td>{{Form::text('relation[]', old('relation') ? old('relation') : (!empty($clientNominee->relation) ? $clientNominee->relation : null),['class' => 'form-control form-control-sm', 'required'] )}}</td>
                                <td>{{Form::textarea('address[]', old('address') ? old('address') : (!empty($clientNominee->address) ? $clientNominee->address : null),['class' => 'form-control form-control-sm', 'rows'=>1,'accept'=>"image/*",'required'] )}}</td>
                                <td>{{Form::file('nominee_picture[]', null,['class' => 'form-control form-control-sm', 'required'] )}}
                                    @if(!empty($client) && $clientNominee->nominee_picture)
                                        <p class="text-left m-0 p-0"><a href="{{ asset("storage/$clientNominee->nominee_picture") }}" target="_blank">See Current Nominee Picture</a></p>
                                    @endif
                                    {{Form::hidden('nominee_old_picture[]', $clientNominee->nominee_picture ? asset("storage/$clientNominee->nominee_picture") : null,['class' => 'form-control form-control-sm'] )}}
                                </td>

                                <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>

                            </tr>
                        @endforeach
                    @endif
                @endif


                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Save</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}


@endsection
@section('script')
    <script>

        var i = "{{!empty($client) ? count($client->clientNominee) : 1}}";
        function addNominee(){
            i++;
            var Row = `
                <tr>
                    <td><input type="text" name="nominee_name[]" value="" class="form-control form-control-sm" required></td>
                    <td><input type="number" name="age[]" value="" class="form-control form-control-sm"  min='0' step='1' max='100' required></td>
                    <td><input type="text" name="relation[]" value="" class="form-control form-control-sm" 'required'></td>
                    <td><textarea name="address[]" class="form-control form-control-sm" rows="1" required></textarea></td>
                    <td><input type="file" name="nominee_picture[]" value="" class="form-control form-control-sm"></td>
                    <input type="hidden" name="nominee_old_picture[]" value="" class="form-control form-control-sm"  accept="image/*" required>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                        </tr>
`;

            var tableItem = $('#nomineeTable').append(Row);
        }
        function removQRow(qval){
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("nomineeTable").deleteRow(rowIndex);
        }

        $(function(){
            @if($formType == 'create' && !old('nominee_name'))
                addNominee();
            @endif

            $('#dob,#marriage_anniversary').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready()


        function loadLeadInformations(){
            const url = '{{url("loadLeadInformations")}}/' + $("#lead_id").val();
            fetch(url)
                .then((resp) => resp.json())
                .then(function(data) {

                    $("#contact").val(data.contact);
                    $("#contact_alternate").val(data.contact_alternate);
                    $("#company_name").val(data.company_name);
                    $("#spouse_name").val(data.spouse_name);
                    $("#spouse_contact").val(data.spouse_contact);
                    $("#nationality").val(data.nationality);
                    $("#email").val(data.email);
                    $("#profession").val(data.profession);
                    $("#present_address").val(data.present_address);
                    $("#permanent_address").val(data.permanent_address);

                })
                .catch(function () {
                    $("#contact, #contact_alternate, #company_name,#spouse_name,#spouse_contact,#nationality,#email,#profession,#present_address,#permanent_address").val(null);
                });

        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $("#name").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{route('leadAutoSuggest')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        },
                        error: function(data){console.log(request.term);}
                    });
                },
                select: function (event, ui) {
                    $('#name').val(ui.item.label);
                    $('#lead_id').val(ui.item.value);
                    return false;
                }
            }).on('change', function () {
                loadLeadInformations();
            });

        });

        $( "#nationality" ).autocomplete({
            source: function( request, response ) {
                // Fetch data
                $.ajax({
                    url:"{{route('countryAutoSuggest')}}",
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
                $('#nationality').val(ui.item.label); // display the selected text
                return false;
            }
        });


    </script>
@endsection
