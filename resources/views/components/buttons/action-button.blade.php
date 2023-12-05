<div class="icon-btn">
    <nobr>
        @if (in_array('approve', $actions))
            <a href="{{ url($url) }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
        @endif
        @if (in_array('edit', $actions))
            <a href="{{ route($route . '.edit', $route_key) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                <i class="fas fa-pen"></i>
            </a>
        @endif
        @if (in_array('show', $actions))
            {{-- <a href="{{ route($route . '.show', $route_key) }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-500 transition duration-500 ease-in-out transform dark:text-gray-400 dark:hover:text-pink-600 hover:-translate-y-1 hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a> --}}
            <a href="{{ route($route . '.show', $route_key) }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
        @endif
        @if (in_array('custom', $actions))
        <a href="#" data-toggle="tooltip" title="Edit" {!! $function !!} class="btn btn-outline-warning {!! $class !!}">
            <i class="fas fa-pen"></i>
        </a>
        @endif
        @if (in_array('delete', $actions))
            <form action="{{ route($route . '.destroy', $route_key) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm delete">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        @endif
        @if (in_array('pdf', $actions))
            <a href="{{ route($route . '.pdf', $route_key) }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
        @endif

    </nobr>
</div>
