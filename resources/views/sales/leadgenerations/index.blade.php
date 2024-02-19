@extends('layouts.backend-layout')
@section('title', 'Lead Generations')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Leads
@endsection


@section('breadcrumb-button')
    @can('leadgeneration-create')
        <a href="{{ url('leadgenerations/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($leadgenerations) }}
@endsection


@section('content')
    <!-- put search form here.. -->
    {{-- <form action="{{ route('search-leadgeneration') }}" method="post"> --}}
    <form action="" method="get">
        @csrf
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" name="prospect_name" class="form-control form-control-sm" list="prospect_list">
                <datalist id="prospect_list">
                    @foreach ($leadgenerations as $key => $leadGeneration)
                        <option>{{ $leadGeneration->name }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                {{--                    <select class="form-control form-control-sm" name="order_by_date"> --}}
                {{--                            <option >Select</option> --}}
                {{--                            <option value="asc">Ascending</option> --}}
                {{--                            <option value="desc">Decending</option> --}}
                {{--                    </select> --}}
                {{ Form::select('order_by_date', ['asc' => 'Ascending', 'desc' => 'Decending'], null, ['class' => 'form-control form-control-sm', 'id' => '', 'autocomplete' => 'off', 'placeholder' => 'Select']) }}
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <select class="form-control form-control-sm" name="user_id">
                    @php
                        $users = App\User::where('department_id', 1)->get();
                    @endphp
                    <option value="">Select User</option>
                    @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <select class="form-control form-control-sm" name="lead_stage">
                    <option value="">Lead Stage</option>
                    <option value="A">Priority</option>
                    <option value="B">Negotiation</option>
                    <option value="C">Lead</option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                @php $projects = App\Project::get(); @endphp
                <select class="form-control form-control-sm" name="project">
                    <option value="">Select Project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
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
    <br>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Prospect Name</th>
                    <th>Entry Date</th>
                    <th>Lead Stage</th>
                    <th>Project</th>
                    <th>Apartment</th>
                    <th>Other Contact</th>
                    <th>Last Followup</th>
                    <th>Entry By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Prospect Name</th>
                    <th>Entry Date</th>
                    <th>Lead Stage</th>
                    <th>Project</th>
                    <th>Apartment</th>
                    <th>Other Contact</th>
                    <th>Last Followup</th>
                    <th>Entry By</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            @php($leadStage = ['A' => 'Priority', 'B' => 'Negotiation', 'C' => 'Lead', 'D' => 'Closed Lead'])
            <tbody>
                @foreach ($leadgenerations as $key => $leadGeneration)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left breakWords">
                            <strong><a target="_blank" href="{{ url("leadgenerations/$leadGeneration->id") }}"
                                    data-toggle="tooltip" title="Check Details"> {{ $leadGeneration->name }}
                                </a></strong><br>
                            {{ $leadGeneration->country_code }}-{{ $leadGeneration->contact }}
                        </td>
                        <td>{{ $leadGeneration->lead_date }}</td>
                        <td>{{ $leadStage[$leadGeneration->lead_stage] }}</td>
                        <td class="breakWords">
                            <strong>{{ $leadGeneration->apartment->project->name }}</strong>
                        </td>
                        <td><strong>{{ $leadGeneration->apartment->name }}</strong></td>
                        <td>
                            {{ $leadGeneration->contact_alternate }} <br>
                            {{ $leadGeneration->contact_alternate_three }} <br>
                            {{ $leadGeneration->spouse_contact }}
                        </td>
                        <td class="breakWords">
                            @if ($leadGeneration->followups()->exists())
                                Date: <strong>{{ $leadGeneration->followups->last()->date }}</strong> <br>
                                Duration:
                                <strong>{{ \Carbon\Carbon::now()->diffInDays($leadGeneration->followups->last()->date) }}</strong>
                                day(s) ago.<br>
                                <hr class="m-1">
                                <strong class="text-left">{{ $leadGeneration->followups->last()->feedback }}</strong>
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            {{ $leadGeneration->createdBy->name }}
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("addfollowup/$leadGeneration->id") }}" data-toggle="tooltip"
                                        title="Add Activity" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                    @can('leadgeneration-view')
                                        <a href="{{ url("leadgenerations/$leadGeneration->id") }}" data-toggle="tooltip"
                                            title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('leadgeneration-edit')
                                        <a href="{{ url("leadgenerations/$leadGeneration->id/edit") }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('leadgeneration-delete')
                                        {!! Form::open([
                                            'url' => "leadgenerations/$leadGeneration->id",
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                        {!! Form::close() !!}
                                        @php($leadName = $leadGeneration->createdBy->name)
                                        <button data-toggle="tooltip"
                                            onclick="modalFunction('{{ $leadName }}',{{ $leadGeneration->id }})"
                                            title="Lead-Transfer" class="btn btn-primary"><i class="fas fa-history"></i>
                                        </button>
                                    @endcan
                                    <a href="{{ url("leadgenerations/{$leadGeneration->id}/log") }}" data-toggle="tooltip"
                                        title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{--  modal start --}}

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 900px!important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> Lead Transfer</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                {!! Form::open(['url' => 'lead-transfer', 'method' => 'POST', 'class' => 'custom-form']) !!}
                <div class="modal-body table-responsive" id="edit-modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger icons-alert mb-2 p-2" id="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled"></i>
                            </button>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="month"> Existing Sales-Man <span
                                        class="text-danger">*</span></label>
                                {{ Form::text('existing_user', old('existing_user') ? old('existing_user') : (!empty($salary) ? date('Y-m', strtotime($salary->existing_user)) : now()->format('Y-m')), ['class' => 'form-control', 'id' => 'existing_user', 'autocomplete' => 'off', 'readonly']) }}
                                {{ Form::hidden('lead_id', old('lead_id') ? old('lead_id') : (!empty($salary) ? date('Y-m', strtotime($salary->lead_id)) : now()->format('Y-m')), ['class' => 'form-control', 'id' => 'lead_id', 'autocomplete' => 'off', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="month"> New Sales-Man <span
                                        class="text-danger">*</span></label>
                                {{ Form::select('transfer_id', $users->pluck('name', 'id'), old('transfer_id') ? old('transfer_id') : (!empty($salary) ? date('Y-m', strtotime($salary->transfer_id)) : now()->format('Y-m')), ['class' => 'form-control', 'id' => 'transfer_id', 'autocomplete' => 'off', 'placeholder' => 'Select User']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-round py-2" data-dismiss="modal">Close</button>
                    <button class="btn btn-success btn-round py-2">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--  modal end --}}

@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });

        function modalFunction(leadName, leadID) {
            $('#existing_user').val(leadName);
            $('#lead_id').val(leadID);
            $('#editModal').modal('show');
        }
    </script>


@endsection
