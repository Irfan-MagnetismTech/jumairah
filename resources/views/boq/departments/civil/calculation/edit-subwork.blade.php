
@foreach ($boq_works as $work)
    <option value="{{ $work->id }}" @if ($work->id == old('work_id', $calculations?->boqCivilCalc?->boqCivilCalcWork?->id ?? -1)) selected @endif>{!! PHP_EOL.$prefix.'-'.PHP_EOL.' ' !!}{{ $work->name }}</option>
    @if (count($work->children) > 0)
        @include('boq.departments.civil.calculation.edit-subwork', ['boq_works' => $work->children,'prefix' => $prefix.'--'])
    @endif
@endforeach
