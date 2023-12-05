@extends('layouts.backend-layout')
@section('title', 'Entry')

@section('breadcrumb-title')
    Profitability Report
@endsection

@section('breadcrumb-button')

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {{-- value for calculation --}}
    <div class="row custom-form">
        <div class="col-md-6 col-xl-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project<span class="text-danger">*</span></label>
                <select class="form-control project_id select2" id="project_id" name="project_id" required>
                    <option value="" disabled selected>Select Project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project?->id }}">
                            {{ $project?->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-2 col-md-2">
            <div class="input-group input-group-sm input-group-primary">
                <p>Project Type</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="project_type"></p>
            </div>
        </div>
    </div><!-- end row -->
    <hr class="bg-success">

    <div class="row custom-form " style="background-color: #c0eec6;">

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3 mt-4">
            <div class="input-group input-group-sm input-group-primary">
                <p>Initiation of Construction Work</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 mt-4">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="initiation_construction_work"></p>
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Expected Handover Date</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="expected_handover_date"></p>
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>BOQ Status</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="boq_status"></p>
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Plot Size (Katha)</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="plot_size"></p>
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Signing Money</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="signing_money"></p>
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>FAR</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="far"></p>
            </div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary"></div>
        </div>

        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>Build Up Area</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <p>:&nbsp;</p>
                <p id="build_up_area"></p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";

        $(document).ready(function() {
            $('.select2').select2();
        });

        $("#project_id").on('change', function() {

            $.ajax({
                url: "{{ route('profitabilityData') }}",
                type: 'get',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    project_id: $("#project_id").val(),
                },
                success: function(data) {
                    console.log(data);
                    $('#project_type').text(data.projectDetails.category);
                    $('#plot_size').text(data.projectDetails.landsize);
                    $('#expected_handover_date').text(data.projectDetails.handover_date);
                    $('#build_up_area').text(data.projectDetails.location);

                }
            });

        });
    </script>
@endsection
