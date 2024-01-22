<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }

        .page-break {
            page-break-after: always;
        }

        .page-number::after {
            counter-increment: page;
            content: counter(page);
        }
    </style>
</head>
<body>

    <div class="table-responsive">
        <table id="" class=" table  table-bordered" width="100%">
            <thead>
            <tr>
                <th>SL</th>
                <th>Material Name</th>
                <th>Unit</th>
            </tr>
            </thead>
            <tbody>
                @foreach($materials as $key => $material)
                    <tr style="background-color: #d5ece8">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left"> {{ $material->name }}</td>
                        <td> {{ $material->unit->name}}</td>
                    </tr>
                    @php $firstancestors = $material->descendants()->where('parent_id', $material->id)->get(); @endphp
                    @foreach($firstancestors as $akey => $firstancestor)
                        <tr>
                            <td>{{ $loop->parent->iteration . '.' . $loop->iteration }}</td>
                            <td class="text-left " style="padding-left: 40px!important;"> {{ $firstancestor->name }}</td>
                            <td> {{ $firstancestor->unit->name}}</td>
                        </tr>
                        @php $secondancestors = $material->descendants()->where('parent_id', $firstancestor->id)->get(); @endphp
                        @foreach($secondancestors as $skey => $secondancestor)
                            <tr>
                                <td>{{ $loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                <td class="text-left " style="padding-left: 80px!important;"> {{ $secondancestor->name }}</td>
                                <td> {{ $secondancestor->unit->name}}</td>
                            </tr>
                            @php $thirdancestors = $material->descendants()->where('parent_id', $secondancestor->id)->get(); @endphp
                            @foreach($thirdancestors as $tkey => $thirdancestor)
                                <tr>
                                    <td>{{ $loop->parent->parent->parent->iteration . '.' . $loop->parent->parent->iteration . '.' . $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                    <td class="text-left " style="padding-left: 120px!important;"> {{ $thirdancestor->name }}</td>
                                    <td> {{ $thirdancestor->unit->name}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach

                {{-- <div class="page-break"></div>
                <div class="page-number">Page </div> --}}
            </tbody>
        </table>
    </div>
</body>
</html>
