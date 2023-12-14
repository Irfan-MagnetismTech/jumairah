<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 14px;
        }

        #detailsTable {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #detailsTable td,
        #detailsTable th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #detailsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #detailsTable tr:hover {
            background-color: #ddd;
        }

        #detailsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #5387db;
            color: white;
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



        .row {
            clear: both;
        }

        .head1 {
            width: 45%;
            float: left;
            margin-top: 80px;
        }

        .head2 {
            width: 55%;
            float: right;
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
        .container {
            margin-right: 10px ;
        }


    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="head1" style="padding-left: 400px; text-align: right">
                {{-- <img src="{{ asset(config('company_info.logo')) }}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}"> --}}
            </div>
        </div>
    </div><br><br>
    <div class="container" style="padding-left: 50px;">
        <table>
            <tr>
                <td>
                    <h6 style="font-size:14px">Date  {{ $letters->letter_date }}</h6>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:14px;font-weight: bold;">To</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:14px">{{ $letters->address_word_one }} &nbsp;{{ $letters->client->name }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:14px">{{ $letters->client->present_address }}</p>
                </td>
            </tr>
        </table><br><br>
        <table>
            <tr>
                <td>
                    <p style="font-size:14px;font-weight: bold;">Subject: {{ $letters->letter_subject }}
                        @if (isset($letters->sell->apartment->name))
                        of Apartment {{ $letters->sell->apartment->name }}
                    @endif

                    @if (isset($letters->project->name))
                        of {{ $letters->project->name }}
                    @endif
                    </p>
                </td>
            </tr>
        </table><br><br>
        <table>
            <tr>
                <td>
                    <p style="font-size:14px;font-weight: bold;">Dear Sir/Madam,</p>
                </td>
            </tr>
        </table>

        <div style="text-align: justify">
            @php
                echo str_replace("&nbsp;"," ","$letters->letter_body")
            @endphp
        </div><br><br><br>

        <table>
            <tr>
                <td>
                    <p style="font-size:14px">Thanking You,</p>
                </td>
            </tr>
        </table><br><br>
        <table>
            <tr>
                <td>
                    <span>---------------------------------</span><br>
                    <span>{{ Auth::user()?->employee?->fullName }}</span><br/>
                    <span>{{ Auth::user()?->employee?->designation?->name }}</span><br>
                    <span>Customer Service Department</span><br>
                    <span>JUMAIRAH HOLDINGS Limited</span><br/>
                    <span>Contact : {{ Auth::user()?->employee?->contact }}</span>
                </td
            </tr>
        </table>
        {{-- <table>
            <tfoot>
                <tr>
                    <td>
                        <p>
                            Atlas Rangs Plaza (Level- 9 & 10), 7, SK. Mujib Road,<br>
                            Agrabad C/A, Chattogram.<br>
                            Phone: 2519906-8, 712023-5 <br>
                            <a style="color:rgb(31, 180, 93);" target="_blank">{!! htmlspecialchars(config('company_info.company_email')) !!}</a>
                        </p>
                    </td>
                    <td>
                        <img src="{{ asset(config('company_info.logo')) }}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" style="padding-left: 230px; text-align: right">

                    </td>
                </tr>
            </tfoot>
        </table> --}}
    </div>
</body>

</html>
