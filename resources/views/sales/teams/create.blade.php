@extends('layouts.backend-layout')
@section('title', 'Teams')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Team
    @else
        Add New Team

    @endif
@endsection
@section('breadcrumb-button')
    <a href="{{ url('teams') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "teams/$team->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($team->id) ? $team->id : null)}}">
    @else
        {!! Form::open(array('url' => "teams",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Team Name<span class="text-danger">*</span></label>
                        {{Form::text('name', old('name') ? old('name') : (!empty($team->name) ? $team->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Name', 'autocomplete'=>"off",'required','title'=>"Name"] )}}
                    </div>
                </div>
                <div div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="head_id">Team Head<span class="text-danger">*</span></label>
                        {{Form::select('head_id', $users, old('head_id') ? old('head_id') : (!empty($team->head_id) ? $team->head_id : null), ['class' => 'form-control form-control-sm','id' => 'head_id', 'placeholder' => 'Select Head','required','title'=>"Name of Head"])}}

                    </div>
                </div>
        </div>
            <hr class="bg-success">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="memberTable" class="table table-striped table-bordered table-sm text-center">
                            <tr>
                                <td class="bg-success" colspan="2"> <h5 class="text-center">Member Information</h5></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th width="40px"><i class="btn btn-success btn-sm fa fa-plus" onclick="addMember()"> </i></th>
                            </tr>
                            <tbody>

                            @if(old('member_id'))
                                @foreach(old('member_id') as $oldKey => $oldItem)
                                    <tr>
                                        <td>
                                            <select class ="form-control form-control-sm" name="member_id[]">
                                                @foreach ($users as $key => $user)
                                                    <option value="{{$key}}" {{ $key == old('member_id')[$oldKey] ? 'selected' : null }}>{{$user}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                                    </tr>
                                @endforeach
                            @else
                                @if(!empty($team))
                                    @foreach($team->members as $member)
                                        <tr>
                                            <td> {{Form::select('member_id[]',$users,$member->member_id,  ['class' => 'form-control form-control-sm member_id','required' ])}}</td>
                                            <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end row -->
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div>
        <!-- end form row -->
        {!! Form::close() !!}

@endsection

@section('script')
    <script>
        function addMember(){
            let Row = `
            <tr>
                <td>{{Form::select('member_id[]', $users,null, ['class' => 'form-control form-control-sm member_id',  'placeholder' => 'Select Member','required'] )}}</td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            <tr>`;
                $('#memberTable').append(Row);
                // $('#parking_no').val($('.parking_name').length);
                }
            $("#memberTable").on('click', '.deleteItem', function(){
            $(this).closest('tr').remove();
            // $('#parking_no').val($('.parking_name').length);
        });

    </script>
@endsection
