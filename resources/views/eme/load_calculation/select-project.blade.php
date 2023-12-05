@extends('layouts.backend-layout')
@section('title', 'BOQ - Select project')

@section('breadcrumb-title') Select project @endsection

@section('content')
    <!-- Projects -->
    <div class="card-columns">
        @foreach ($projects as $project)
            <a href="{{ route('eme.show_load_cal', ['project' => $project]) }}">
                <div class="card bg-primary">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $project?->name }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
