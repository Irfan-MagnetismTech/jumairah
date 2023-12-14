<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 3px !important;
            padding:3px !important;
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

        /* .container {
            margin: 20px;
        } */

        .row {
            clear: both;
        }

        .head1 {
            width: 45%;
            float: left;
            margin: 0;
        }

        .head2 {
            width: 55%;
            float: left;
            margin: 0;
        }

        .head3 {
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }

        .head4 {
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }

        .textarea {
            width: 100%;
            float: left;
        }

        .text-center {
            text-align: center;
        }

        .text-4xl {
            font-size: 1.5rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-base {
            font-size: 0.875rem;
        }

        .text-sm {
            font-size: 0.75rem;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .flex {
            display: flex;
        }

        .mt-12 {
            margin-top: 3rem;
        }

        .justify-between {
            justify-content: space-between;
        }

        .flex-col {
            flex-direction: column;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .justify-between {
            justify-content: space-between;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        #allowances,
        #allowances td,
        #allowances th {
            padding: 5px;
            border-collapse: collapse;
            border: 1px solid black;

        }



        .text-4xl {
            font-size: 24px;

        }

        #orderinfo-table tr td {
            border: 1px solid #ffffff;
        }

        #orderinfo-table2 tr td {
            border: 1px solid #ffffff;
            text-align: left;
        }

        .search-criteria-container{
            font-size: 12px;
        }
        .search-criteria-container h6{
            font-size: 12px;
            margin: 0;
        }




        @page {
            /* header: page-header; */
            /* footer: page-footer; */
            /* margin: 120px 50px 50px 50px; */
            /* margin: 130px 50px 90px 50px; */
        }
    </style>
    <title>Employee ID Card</title>
</head>

<body>
    <div class="container" >
        @foreach ($employees as $key => $e)
        <div id="idcard-container">
            <div class="left-side">
               <div class="left-logo-container">
                    <img src="{{ base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/mh-logo.jpg') }}" id="left-logo">
               </div>
               <div class="left-profile-img-container">
                    <img src="{{ $e->emp_img_url? '/emp_img/'.$e->emp_img_url :  base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/avatar.png') }}" class="left-profile-img">
               </div>
               <h2 class="uppercase text-center"  style="font-size: 12px">{{$e->emp_name}}</h2>
               <h2 class="uppercase text-center"  style="font-size: 8px">{{$e->designation->name}}</h2>
               <h2 class="uppercase text-center"  style="font-size: 9px;margin-top:20px; margin-bottom:20px;">Mostofa Hakim Group</h2>
            </div>
            <div class="right-side">
               <div class="right-side-inner">
               <div style=" padding-left:25px; padding-top: 15px ;">
                <h3  style="font-size: 8px" >ID NO  : {{$e->emp_code}}</h3>
                <h3 style="font-size: 8px">PHONE  : {{$e->phone_1}}</h3>
                <h3 style="font-size: 8px">EMAIL  : {{$e->email}}</h3>
                <h3 style="font-size: 8px">BLOOD GROUP: {{$e->blood_group}}</h3>
               </div>
                <br>
                <h2 class="uppercase text-center" style="font-size: 8px;margin-bottom:2px;">Mostofa Hakim Group</h2>
                <p class="text-center"  style="font-size: 7px"> 218 Dewanhat, DT Road</p>
                <p class="text-center"  style="font-size: 7px"> Chittagong - 4100</p>
                <p class="text-center"  style="font-size: 7px"> 88-031-710-610, 720288, 710610</p>
                <p class="text-center"  style="font-size: 7px"> Fax: 880-31-5263 </p>
                <p class="text-center"  style="font-size: 7px"> www.mostofahakim.com </p>

                <hr style="margin-top:36px; margin-bottom:2px; text-align:center; width:65%" >
                <p class="uppercase text-center" style="font-size:7px">Authorized Signature</p>
               </div>
            </div>
        </div>
        @if (count($employees)-1 >$key)
        <pagebreak>
        @endif
        @endforeach
        <style>
            #idcard-container{
                width:   350px;
                height: 300px;
            }
            .left-side{
                width:156px;
                height: 258px;
                float: left;
                background-image: url("{{ base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/mh-id-1.png') }}");
                background-repeat: no-repeat;
                background-size: 100% 100%;
                border:1px solid rgb(103, 103, 103);
            }

            .left-logo-container{
                width:100%;
                text-align: center;
            }

            #left-logo{
                width: 30%;
                margin-top: 15px;
            }

            .left-profile-img-container{
                text-align: center;
            }

            .left-profile-img{
                margin-top: 25;
                margin-bottom: 20px;
                width:65px;
                height: 65px;
                border: 2px solid grey;
            }

            .right-side{
                width:156px;
                height: 258px;
                float: right;
                background-image: url("{{ base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/mh-id-2.png') }}");
                background-repeat: no-repeat;
                background-size: 100% 100%;
                border:1px solid rgb(103, 103, 103);
            }
        </style>
    </div>
</body>

</html>
