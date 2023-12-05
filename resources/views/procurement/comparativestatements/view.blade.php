@extends('layouts.backend-layout')
@section('title', 'Comparative Statement')

@section('breadcrumb-title')
    Comparative Statement (CS) Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('comparative-statements') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('style')
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 12px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            /* background-color: grey; */
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }

        .infoTable {
            font-size: 12px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin: 40px 0 0 0;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 20;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }
        .foot_container {
            margin: 20px;
            margin-bottom: 60px;
        }

    </style>
@endsection


@section('content')
    <!-- put search form here.. -->
    @php
        $iteration = 1;
    @endphp

    @php $price_index = 0; @endphp
    <table id="table" class="table table-striped table-bordered">
        <thead>
            <tr style="vertical-align: middle" class="text-center">
                <th width="20px">SL No</th>
                <th width="100px">Material's Name</th>
                <th width="30px">Unit</th>
                @forelse ($comparative_statement->csSuppliers as $cs_supplier)
                    <th width="120px">
                        <span>{{ $cs_supplier->supplier->name }}</span> <br>
                        <span>{{ $cs_supplier->supplier->address }}</span> <br>
                        <span>{{ $cs_supplier->supplier->contact }}</span> <br>
                        <span>{{ $cs_supplier->collection_way }}</span> <br>
                        <span>{{ $cs_supplier->is_checked ? 'Selected' : '' }}</span> <br>
                    </th>
                @empty
                @endforelse
                {{-- <th width="60px">Remarks</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($comparative_statement->csMaterials->chunk(5) as $chunk)
                @php $price_index = 0; @endphp
                @foreach ($chunk as $cs_material)
                    <tr>
                        <td style="text-align: center font-weight-bold">{{ $iteration++ }}</td>
                        <td style="text-align: center"><b>{{ $cs_material->nestedMaterial->name }}</b></td>
                        <td style="text-align: center">{{ $cs_material->nestedMaterial->unit->name }}</td>
                        @forelse ($comparative_statement->csSuppliers as $cs_supplier)
                            <td style="text-align: center">
                                {{ $comparative_statement->csMaterialsSuppliers->where('cs_material_id', $cs_material->id)->where('cs_supplier_id', $cs_supplier->id)->first()->price }}
                            </td>
                        @empty
                        @endforelse

                        {{-- @if ($loop->first)
                            <td style="text-align: center" rowspan="{{ count($chunk) }}">
                                {{ $comparative_statement->remarks }}</td>
                        @endif --}}
                    </tr>
                @endforeach
                @endforeach
                <tr>
                    <td style="text-align: center">---</td>
                    <td>Terms & Condition</td>
                    <td colspan="{{ count($comparative_statement->csSuppliers) + 1 }}"></td>
                </tr>
                @php
                    $other_details = [
                        'grade' => 'Grade',
                        'vat_tax' => 'Vat & Tax',
                        'credit_period' => 'Credit Period',
                        'material_availability' => 'Material Availability',
                        'delivery_condition' => 'Delivery Condition',
                        'required_time' => 'Load time required by supplier',
                        'remarks' => 'Remarks',
                    ];
                @endphp

                @foreach ($other_details as $key => $value)
                    <tr>
                        <td style="text-align: center">---</td>
                        <td>{{ $value }}</td>
                        <td></td>
                        @forelse ($comparative_statement->csSuppliers as $cs_supplier)
                            <td style="text-align: center">{{ $cs_supplier[$key] }}</td>
                        @empty
                        @endforelse
                        {{-- <td></td> --}}
                    </tr>
                @endforeach
        </tbody>
    </table>

    <div class="foot_container">
        <p><span style="text-decoration: underline;">Remarks:</span></p>
        <p>
            {{ $comparative_statement->remarks }}
        </p>
    </div>


@endsection
