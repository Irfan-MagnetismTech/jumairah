@php
if ($type == 'create') {
    $class = 'success';
    $icon = 'fa fa-plus';
} elseif ($type == 'index') {
    $class = 'warning';
    $icon = 'fas fa-database';
}

@endphp
<a href="{{ $route }}" class="btn btn-out-dashed btn-sm btn-{{ $class ?? '' }}">
    <i class="{{ $icon }}"></i>
</a>
