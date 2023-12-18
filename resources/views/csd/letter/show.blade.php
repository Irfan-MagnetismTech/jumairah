@extends('layouts.backend-layout')
@section('title', 'Letter')

@section('breadcrumb-button')

<a href="{{ url("csd/send-mail/$letters->id") }}" data-toggle="tooltip" title="Send Mail" data-placement="left" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-rocket"></i></a>
<a href="{{ url(route("csd.letter.index")) }}" data-toggle="tooltip" title="Letter List" data-placement="right" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

{{-- @section('content-grid', null)  --}}

@section('content')
        <br><br><br><br>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <h6>Date  {{ $letters->letter_date }}</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <h6>To</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-8 col-md-8">
                <div class="input-group input-group-sm input-group-primary">
                    <b>{{ $letters->address_word_one }} &nbsp;{{ $letters->client->name }}<b>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    {{ $letters->client->present_address }}
                </div>
            </div>
        </div><br>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-1 col-md-1">
                <div class="input-group input-group-sm input-group-primary">
                    <h6>Subject: </h6>
                </div>
            </div>
            <div class="col-xl-9 col-md-9">
                <div class="input-group input-group-sm input-group-primary">
                    <h6 style="text-align: justify; ">
                        {{ $letters->letter_subject }}
                        @if (isset($letters->sell->apartment->name))
                            of Apartment {{ $letters->sell->apartment->name }}
                        @endif

                        @if (isset($letters->project->name))
                            of {{ $letters->project->name }}
                        @endif
                    </h6>
                </div>
            </div>
        </div><br><br>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <h6 >Dear Sir/Madam,</h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-10 col-md-10">
                <div class="input-group input-group-sm input-group-primary">
                    <span style="word-break:break-all; text-align:justify">{!! $letters->letter_body !!}</span>
                </div>
            </div>
        </div><br><br><br><br>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-4 col-md-4">
                <table>
                    <tr>
                        <td>
                            <span>Thanking You,</span><br><br><br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-md-1"></div>
            <div class="col-xl-4 col-md-4">
                <table>
                    <tr class="text-left">
                        <td>
                            <span>---------------------------------</span><br>
                            <span><b>{{ Auth::user()?->employee?->fullName }}<b></span><br/>
                            <span>{{ Auth::user()?->employee?->designation?->name }}</span><br>
                            <span>Customer Service Department</span><br>
                            <span>Jumairah Holdings Limited</span><br/>
                            <span>Contact : {{ Auth::user()?->employee?->contact }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div><br><br><br>
{!! Form::close() !!}

@endsection
