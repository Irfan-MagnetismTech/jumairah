@csrf
<div class="row">
    <div class="col-md-12 mt-4 floor">
        <h6>Total Area: <span class="" id="total_area">0.00</span> SFT</h6>
    </div>
    @foreach ($boq_floor_projects as $area)
        @if ($area?->boqCommonFloor?->floor_type->has_buildup_area == 1)
            <div class="col-md-12 mt-4 floor">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="area">{!! $area->boqCommonFloor->name ?? '' !!}<span class="text-danger">*</span></label>
                    <input type="hidden" name="boq_floor_project_id[]" value="{!! $area->boq_floor_project_id !!}">
                    <input type="number" id="area" name="area[]" step=".01" value="{{ old('area', $area->area ?? '') }}" class="form-control area" placeholder="Enter area for {!! $area->boqCommonFloor->name ?? '' !!}" autocomplete="off">
                </div>
            </div>
        @endif
    @endforeach
</div>

@can('boq-configuration-edit')
    <!-- Submit button -->
    @if ($approval == 0)
        @include('components.buttons.submit-button', ['label' => 'Save'])
    @endif

    @if ($boq_floor_projects)
    <div class="row">
        <div class="mt-2 offset-md-5 col-md-2">
            <div class="input-group input-group-sm">
                @if ($approval == 0)
                @if ($boq_floor_projects->sum('area') > 0)
                @can('boq-floorwise-project-approval')
                <button type="button" class="py-2 btn btn-warning btn-round btn-block"><a href="{{ route('boq.project.configurations.floorApproval', ['project' => $project]) }}" class="text-white">Approve</a></button>
                @endcan
                @endif
                @else
                <button type="button" class="py-2 btn btn-info btn-block">Approved</button>
                @endif
            </div>
        </div>
    </div>
    @endif

@endcan

@section('script')
    <script>
        const TOTAL_AREA = $('#total_area');

        /* Calculates and prints total area */
        function totalArea() {
            var total = 0.00;
            $('input[name="area[]"]').each(function() {
                total += parseFloat($(this).val() ? $(this).val() : 0.00);
            });
            //$('#total_area').html(total)
            TOTAL_AREA.html(total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }

        /* Calculates total area */
        $(document).on('keyup', 'input[name="area[]"]', function() {
            totalArea();
        });

        /* The document function */
        $(function() {
            totalArea();
        });
    </script>
@endsection
