<div class="row">
    <div class="col-xl-12 col-md-12" id="works-table">
        <div class="input-group input-group-sm input-group-primary" id="work-0">
            <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
            <select class="form-control work_id" id="work_id" name="work_id[]" required>
                <option value="">Select Work</option>
                @foreach ($boq_works as $work)
                    <option value="{{ $work->id }}">{{ $work->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const BOQ_SUB_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.civil.configurations.get_boq_sub_work_by_work_id', $project) }}";

        /* Checks if the object is empty or not */
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        /* Appends Subwork */
        function appendSubWork(workId, trId, subWorks) {
            var rowCount = $('#works-table div').length;
            let options = "";

            for (let i = trId + 1; i <= rowCount; i++) {
                $('#work-' + i).remove();
            }

            for (let i = 0; i < subWorks.length; i++) {
                options += `<option value="${subWorks[i].id}">${subWorks[i].name}</option>`;
            }

            let row = `<div class="input-group input-group-sm input-group-primary" id="work-${trId + 1}">
                        <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                        <select class="form-control work_id" id="work_id" name="work_id[]" required>
                            <option value="">Select Work</option>
                            ${options}
                        </select>
                    </div> `;

            if (!isObjectEmpty(subWorks)) {
                $('#works-table').append(row);
            }
        }

        /* Get sub work by work id */
        async function getSubWorkByWork(workId, trId) {
            let response = await axios.post(BOQ_SUB_WORK_BY_WORK_ID_URL, {
                _token: "{{ csrf_token() }}",
                work_id: workId
            });

            let data = await response.data;

            appendSubWork(workId, trId, data);

            if (isObjectEmpty(data)) {
                getWorkDetails(workId);
            }
        }

        /* On change of #works-table */
        $('#works-table').on('change', '.work_id', function() {
            let workId = $(this).val();
            let trId = parseInt($(this).closest('div').attr('id').split('-')[1]);

            getSubWorkByWork(workId, trId);
        });
    </script>
@endsection
