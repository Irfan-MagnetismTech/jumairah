
@foreach ($works as $single_work)
    <option value="{{ $single_work->id }}" @if ($single_work->id == old('work_id', $materialFormula->work_id ?? -1)) selected @endif>{!! PHP_EOL.$prefix.'-'.PHP_EOL.' ' !!}{{ $single_work->name }}</option>
    @if (count($single_work->children) > 0)
        @include('boq.configurations.work.subwork', ['works' => $single_work->children,'prefix' => $prefix.'-'])
    @endif
@endforeach
