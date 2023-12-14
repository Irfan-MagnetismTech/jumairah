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
            font-size:10px;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ddd;
            color: black;
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
        .row{
            clear: both;
        }
        .head1{
            width: 45%;
            float: left;
            margin: 0;
        }
        .head2{
            width: 55%;
            float: right;
            margin: 0;
        }
        .head3{
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }
        .head4{
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }
        td{
            text-align: center;
        }
        .textarea{
            width: 100%;
            float: left;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="head1">
            <img class="float-right" style="height: 50px;width: 110px;" src="{{asset('images/logo-apoil.png')}}" alt="logo-apoil.png">
            <p>[Street Address]</p>
            <p>[City. ST ZIP]</p>
            <p>Phone:(000) 000.0000</p>
            <p>Fax:(000) 000.0000</p>
            <p>Website:</p>
        </div>
        <br>

        <div class="head2">
            <h1 style="font-size: 20px; text-transform: uppercase; text-align: right">Current Stock List</h1>


        </div>

    </div>
</div>



<div style="clear: both"></div>
<div class="container" style="margin-top: 30px;">
    <table id="customers">
        <thead>
        <tr>
            <th>SL</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Minimum Level</th>
        </tr>
        </thead>
        <tbody>

        @foreach($datas as $key => $data)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->rawMaterial->name}}</td>
                <td>{{$data->quantity}}</td>
                <td>{{$data->rawMaterial->min_quantity}}</td>
            </tr>
        @endforeach
        </tbody>



    </table>
</div>

<div class="container">
    {{--<div class="row">--}}
        {{--<div class="textarea">--}}
            {{--<p style="width: 100%; background-color: #dddddd; margin-bottom: 0px; padding: 10px 0;">Comments or Special Instructions</p>--}}
            {{--<textarea style="width: 100%; margin-top: 0px; height: 100px;"></textarea>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
<div class="container">
    <div class="row">
        <p style="text-align: center;">If you have any questions about this purchase , Please contact <br> [Name, Phone #, E-mail]</p>
    </div>
</div>


</body>
</html>


