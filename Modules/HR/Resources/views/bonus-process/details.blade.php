@extends('layouts.backend-layout')
@section('title', 'Processed Bonus Details')

@section('breadcrumb-title')
Processed Bonus Details
@endsection
{{-- {{ dd($processed_bonus) }} --}}
@section('breadcrumb-button')
<a href="{{ route('bonus-process.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-6">
        <ul>
            <li class="py-1"><strong>Department: </strong>{{$processed_bonus->processedBonusDetails?->first()?->employee?->department?->name ?? ''}}</li>
            <li class="py-1"><strong>Bonus Name: </strong> {{ $processed_bonus->bonus?->name }}</li>
            <li class="py-1"><strong>Date: </strong> {{ $processed_bonus->date }}</li>
        </ul>
    </div>



</div> <!-- end row -->
<br>

<div class="table-responsive">
       <table id="example" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Designation</th>
                <th>Employee Type</th>
                <th>Bonus Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($processed_bonus->processedBonusDetails as $key => $processedBonusDetail)
            <tr>
                <td>{{$processedBonusDetail->employee?->emp_name}}</td>
                <td>{{$processedBonusDetail->employee?->emp_code}}</td>
                <td>{{$processedBonusDetail->employee?->designation?->name}}</td>
                <td>{{$processedBonusDetail->employee?->employee_type?->name}}</td>
                <td class="text-right">@money($processedBonusDetail->bonus_amount)</td>

            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
