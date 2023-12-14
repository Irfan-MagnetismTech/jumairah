@csrf
<div class="row">
    <!-- Sortable -->
    <div class="col-xl-12 col-md-12 mt-4" id="buildup_area">
        <table class="table text-center table-striped table-sm table-bordered" id="floor_type_table">
            <thead>
                <tr>
                    <th>Floor type name <span class="text-danger">*</span></th>
                    <th>Has buildup area</th>
                    <th>
                        <i class="btn btn-primary btn-sm fa fa-plus" id="add_floor_type"></i>
                    </th>
                </tr>
            </thead>
            <tbody id="sortable"></tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        The floor types can be sorted.
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@section('script')
    <script>
        const SORTABLE = $('#sortable');
        const FLOOR_TYPE_TABLE = $('#floor_type_table')
        const floorTypes = @json($floor_types);
        const oldFloorTypes = @json(old());

        /* Checks if an object is empty or not */
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        /* Appends new sortable row */
        function appendSortableRow(name = '', has_buildup_area = 0) {
            let isChecked = Number(has_buildup_area) === 1 ? 'checked' : '';
            var row = '<tr>' +
                `<td>
                    <input type="text" name="name[]" value="${name}"class="form-control" placeholder="Area / Floor name" required>
                </td>` +
                `<td>
                    <input type="checkbox" ${isChecked} class="has_buildup_area_check">
                    <input type="hidden" name="has_buildup_area[]" value="${has_buildup_area}">
                </td>` +
                '<td><i class="btn btn-danger btn-sm fa fa-minus delete-item"></i></td>' +
                '</tr>';

            SORTABLE.append(row);
        }

        /* Adds a row */
        $('#add_floor_type').click(function() {
            appendSortableRow();
        });

        /* Deletes the selected row */
        $(FLOOR_TYPE_TABLE).on('click', '.delete-item', function() {
            $(this).closest('tr').remove();
        });

        /* Checks if the floor type has a buildup area */
        $(FLOOR_TYPE_TABLE).on('change', '.has_buildup_area_check', function() {
            var has_buildup_area = $(this).is(':checked') ? 1 : 0;
            $(this).closest('td').find('input[name="has_buildup_area[]"]').val(has_buildup_area);
        });

        /* The document function */
        $(function() {
            /* Enables sorting functionality */
            SORTABLE.sortable();

            /* Checks if there is any old input value */
            if (!isObjectEmpty(oldFloorTypes)) {
                for (let i = 0; i < oldFloorTypes.name.length; i++) {
                    appendSortableRow(oldFloorTypes.name[i], oldFloorTypes.has_buildup_area[i]);
                }
            }

            /* If there is no old value, then iterates over the data */
            else if (floorTypes.length) {
                floorTypes.forEach((item) => {
                    appendSortableRow(item.name, item.has_buildup_area);
                })
            }
        });
    </script>
@endsection
