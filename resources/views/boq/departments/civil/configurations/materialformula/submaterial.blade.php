@foreach ($nested_materials as $single_material)
    <option value="{{ $single_material->id }}" @if ($single_material->id == old('nested_material_id', $materialFormula->nested_material_id ?? -1)) selected @endif>{!! PHP_EOL . $prefix . '-' . PHP_EOL . ' ' !!}{{ $single_material->name }}</option>
    @if (count($single_material->children) > 0)
        @include('boq.departments.civil.configurations.materialformula.submaterial', ['nested_materials' => $single_material->children, 'prefix' => $prefix . '-'])
    @endif
@endforeach
