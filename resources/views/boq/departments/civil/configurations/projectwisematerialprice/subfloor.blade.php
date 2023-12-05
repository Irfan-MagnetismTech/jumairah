
@foreach ($floors as $single_floor)
    <option value="{{ $single_floor->id }}" @if ($single_floor->id == old('parent_id', $floor->parent_id ?? -1)) selected @endif>{!! PHP_EOL.$prefix.'-'.PHP_EOL.' ' !!}{{ $single_floor->name }}</option>
    @if (count($single_floor->children) > 0)
        @include('boq.configurations.floor.subfloor', ['floors' => $single_floor->children,'prefix' => $prefix.'-'])
    @endif
@endforeach
