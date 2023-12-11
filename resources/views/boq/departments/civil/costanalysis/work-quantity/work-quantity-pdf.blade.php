<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
            margin: 0;
            padding: 0;
        }
        table{
            font-size:9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #227447;
            color: white;
        }
        .tableHead{
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p{
            margin:0;
        }
        h1{
            margin:0;
        }
        h2{
            margin:0;
        }
        .container{
            margin: 20px;
        }
        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
        }
        .pdflogo a{
            font-size: 18px;
            font-weight: bold;
        }

        .text-center{
            text-align: center;
        }

        /* Page break */
        @page { margin: 30px 20px 20px 20px; }

        @media print {
            body{
                margin: 30px 20px 20px 20px;
            }
        }

        footer{
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            width: 100%;
            display: block;
            margin-left: 20px;
        }

    </style>
    <title>Work Quantity</title>
</head>
<body>


<div id="logo" class="pdflogo">
    <img src="{{ asset(config('company_info.logo'))}}" alt="Logo" class="pdfimg">
    <h5>JHL Address.</h5>
    <h2>{{ $project->name }}</h2>
</div>

<div class="container">
    <div class="row">
       <table id="table" class="text-center">
           <thead>
               <tr>
                   <th colspan="5">WORK QUANTITY SHEET</th>
               </tr>
              <tr>
                  <th>SL.</th>
                  <th>Area/Location</th>
                  <th>Work Name</th>
                  <th>Unit</th>
                  <th>Quantity</th>
              </tr>
           </thead>
           <tbody>
           <?php
           $headWiseTotalAmount = 0;
           $sl = 1;
           ?>
           @foreach ($boqCivilBudgets as $key => $boqCivilBuget)
               @foreach ($boqCivilBuget as $miniKey => $boqCivilBugetItem)
                   @if($sl % 2 == 0)
                       <?php $row_bg_color = '#f0efed'; ?>
                   @else
                       <?php $row_bg_color = '#c9c7c1'; ?>
                   @endif

                   <tr style="background-color: {{ $row_bg_color }};">
                       @if ($loop->first)
                           <td style="" class="text-center">
                               @if ($loop->first)
                                   {{ $sl }}
                               @endif
                           </td>
                           <td style="font-size: 12px;text-align: left"
                               class="text-center">
                               @if ($loop->first)
                                   {{ $boqCivilBuget?->first()->boqCivilCalcProjectFloor?->floor?->name }}
                               @endif
                           </td>
                       @else
                           <td></td>
                           <td></td>
                       @endif


                       <td style="text-align: left;font-size: 11px">
                           @foreach ($boqCivilBugetItem?->boqCivilCalcWork?->ancestors as $ancestor)
                               @if (!$loop->first)
                                   {{ $ancestor?->name }} ->
                               @endif
                           @endforeach
                           {{ $boqCivilBugetItem?->boqCivilCalcWork?->name }}
                       </td>
                       <td style="text-align: center">
                           @php
                               $boqUnit = \App\Procurement\Unit::find($boqCivilBugetItem?->boqCivilCalcWork?->unit_id);
                           @endphp
                           {{ $boqUnit?->name }}
                       </td>
                       <td style="font-size: 12px;text-align: right">
                           <span>@money($boqCivilBugetItem?->total)</span>
                       </td>
                   </tr>
               @endforeach
               <?php $sl++; ?>
           @endforeach
           </tbody>
       </table>
    </div>
</div>

<footer>
    <p>Printing Time: {{date('d-M-y h:i:s a', strtotime(now()))}}</p>
</footer>

</body>
</html>
