<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;  }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #1ABB9C;
            color: white;
        }
        p {
            margin-top: 0;
            margin-bottom: -2px;
        }
        h4{
            margin-bottom: 2px;
        }

    </style>

</head>
<body>
<div class="row">
    <div class="col-md-6"><a href="{{route('home')}}">
            <h4 class="my-3">
                {{--APOIL--}}
                <img src="{{asset('images/logo-apoil-name.png')}}" style="padding-left: 30px;" alt="">
            </h4>
        </a></div>
    <div class="col-md-6" style="text-align: right">
        <h4 style="color: darkblue">Apoil</h4>
        <p>Call Us <span>+031-718231</span></p>
        <p>Address <span>kjreugn9g</span></p>
    </div>

</div>
<h5 style="text-align: center"> Supplier Stock</h5>


<table id="customers" class="table">
    <tr>
        <th >SL</th>
        <th >Raw Material</th>
        <th >Quantity</th>
    </tr>
    {{--@foreach($suppliers as $supplier)--}}
        {{--@foreach($supplier->purchaseDetails as $purchaseDtl)--}}
            {{--<tr>--}}
                {{--<td>{{$loop->iteration}}</td>--}}
                {{--<td>{{$supplier->date}}</td>--}}
                {{--<td>--}}
                    {{--{{$purchaseDtl->rowMetarials->name ?? ''}}<br>--}}
                {{--</td>--}}
                {{--<td>{{$purchaseDtl->quantity ?? ''}}</td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}

    {{--@endforeach--}}


</table>

</body>
</html>
