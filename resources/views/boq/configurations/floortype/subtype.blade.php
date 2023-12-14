
@foreach ($floor_types as $type)
    <option value="{{ $type->id }}" @if ($type->id == old('parent_id', $floorType->parent_id ?? -1)) selected @endif>{!! PHP_EOL.$prefix.'-'.PHP_EOL.' ' !!}{{ $type->name }}</option>
    @if (count($type->children) > 0)
        @include('boq.configurations.floortype.subtype', ['floor_types' => $type->children,'prefix' => $prefix.'-'])
    @endif
@endforeach
