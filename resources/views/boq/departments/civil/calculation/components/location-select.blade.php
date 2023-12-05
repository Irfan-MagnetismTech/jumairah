<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="location-type">Location Type<span class="text-danger">*</span></label>
            <select class="form-control location_type" id="location-type" name="boq_floor_type[]" required>
                <option value="">Select Location Type</option>
                @foreach ($boq_floor_types as $boq_floor_type)
                    <option value="{{ $boq_floor_type->id }}">{{ $boq_floor_type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xl-12 col-md-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="location">Select Location<span class="text-danger">*</span></label>
            <select class="form-control location" id="location" name="boq_floor_id[]" required>
                <option value="">Select Floor</option>
            </select>
        </div>
    </div>
</div>
@section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const GET_FLOOR_BY_TYPE_URL = "{{ route('boq.project.departments.civil.get_floor_by_type', $project) }}";

        /* Checks if the object is empty or not */
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        function appendLocationOptions(data) {
            if (isObjectEmpty(data)) {
                $('#location').empty();
                $('#location').append('<option value="">No Floor Found</option>');
            } else {
                $('#location').empty();
                $('#location').append('<option value="">Select Floor</option>');
                data.forEach(function(item) {
                    $('#location').append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            }
        }

        /* Get floor by type */
        async function getFloorByType(floorTypeId) {
            const response = await axios.post(GET_FLOOR_BY_TYPE_URL, {
                floor_type: floorTypeId,
                _token: "{{ csrf_token() }}"
            });

            appendLocationOptions(response.data);
        }

        /* On change of #location-type */
        $('#location-type').on('change', function() {
            getFloorByType($(this).val());
        });
    </script>
@endsection
