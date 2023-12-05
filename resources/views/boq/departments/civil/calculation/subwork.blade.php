
@foreach ($boq_works as $work)
    <option value="{{ $work->id }}">{!! PHP_EOL.$prefix.'-'.PHP_EOL.' ' !!}{{ $work->name }}</option>
    @if (count($work->children) > 0)
        @include('boq.departments.civil.calculation.subwork', ['boq_works' => $work->children,'prefix' => $prefix.'--'])
    @endif
@endforeach
