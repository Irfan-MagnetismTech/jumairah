@section('title', 'Dashboard - Apoil')

@include('elements.header')
@include('elements.sidebar-chat')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
{{--        @include('elements.sidebar')--}}
        <div class="container p-50">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{route('grease')}}">
                        <div style="background-color:darkblue" >
                            <h3 class="p-30 text-center" style="color: white">Grease</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('lube')}}">
                        <div style="background-color:green" >
                            <h3 class="p-30 text-center" style="color: white">Lube</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('treading')}}">
                        <div style="background-color:purple" >
                            <h3 class="p-30 text-center" style="color: white">Treading</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.footer')
