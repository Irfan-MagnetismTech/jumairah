@foreach ($works as $single_work)
    <option value="{{ $single_work->id }}" @if ($single_work->id == old('parent_id', $work->parent_id ?? -1)) selected @endif>{!! PHP_EOL . $prefix . '_' . PHP_EOL . ' ' !!}{{ $single_work->name }} -(<strong>{{ $single_work->calculation_type }}</strong>)</option>
    @if (count($single_work->children) > 0)
        @include('boq.departments.civil.configurations.work.subwork', ['works' => $single_work->children, 'prefix' => $prefix . '__'])
    @endif
@endforeach
