<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 3px !important;
            padding: 3px !important;
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

        .text-4xl {
            font-size: 24px;

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
    <div class="container">
        @foreach ($employees as $key => $e)
            <div id="idcard-container">
                <div class="left-side">
                    <div class="left-profile-img-container">
                        <img src="{{ $e->emp_img_url ? '/emp_img/' . $e->emp_img_url : base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/avatar.png') }}"
                            class="left-profile-img">
                    </div>
                    <h2 class="emp_name uppercase" style="font-size: 12px">{{ $e->emp_name }}</h2>
                    <p class="emp_designation uppercase" style="font-size: 8px">{{ $e->designation->name }}</p>
                    <p class="emp_designation uppercase" style="font-size: 8px">HM Steel & Industry Ltd</p>
                    <div style="margin-left:20px;margin-top:20px;">
                        <p style="font-size: 8px">ID
                            NO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $e->emp_code }}</p>
                        <p style="font-size: 8px">BLOOD GROUP&nbsp;&nbsp;: {{ $e->bllod_group }}</p>
                        <p style="font-size: 8px">
                            DOB&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $e->birth_date }}</p>
                    </div>
                </div>
                <div class="right-side">
                    <div class="right-side-inner">
                        <div class="right-logo-container" style="text-align: center">
                            <img src="{{ base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/hm-logo.png') }}"
                                id="right-logo" style="width:84%">
                        </div>
                        <div style="text-align: center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12">
                                <path
                                    d="M20 20.0001C20 20.5524 19.5523 21.0001 19 21.0001H5C4.44772 21.0001 4 20.5524 4 20.0001V11.0001L1 11.0001L11.3273 1.61162C11.7087 1.26488 12.2913 1.26488 12.6727 1.61162L23 11.0001L20 11.0001V20.0001ZM7 11.0001V13.0001C9.76142 13.0001 12 15.2387 12 18.0001H14C14 14.1341 10.866 11.0001 7 11.0001ZM7 15.0001V18.0001H10C10 16.3432 8.65685 15.0001 7 15.0001Z">
                                </path>
                            </svg>
                            <p style="text-align: center;font-size:8px">
                                210 DT Road, Dewanhat
                                <br>
                                Chottogram -4100, Bangladesh
                            </p>
                            <br>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12">
                                <path
                                    d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.1633 21 16.42Z">
                                </path>
                            </svg>
                            <p style="text-align: center;font-size:8px">
                                +88-031-710610,+88-031-71671
                                <br>
                                +88-031-720-228
                            </p>
                            <br>
                            <h4 class="uppercase text-center" style="font-size: 10px">Expired: {{ $expired }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($employees) - 1 > $key)
                <pagebreak>
            @endif
        @endforeach
        <style>
            #idcard-container {
                width: 350px;
                height: 300px;
            }

            .left-side {
                width: 156px;
                height: 260px;
                float: left;
                /* background-image: url('/idcard/hm-id-1.png'); */
                background-image: url("{{ base_path('Modules/HR/Resources/views/idcard-appointment-letter/idcard-img/hm-id-1.png') }}");
                background-repeat: no-repeat;
                background-size: 100% 100%;
                border: 1px solid red;
            }

            .left-profile-img-container {
                text-align: center;
                margin-bottom: 6px;
            }

            .left-profile-img {
                margin-top: 37px;
                width: 56px;
                height: 56px;
            }

            .emp_name {
                margin-top: 26px;
                font-size: 32px;
                text-align: center;
            }

            .emp_designation {
                font-size: 22px;
                text-align: center;

            }

            .right-side {
                width: 156px;
                height: 244px;
                float: right;
                border: 1px solid red;
            }

            .right-side-inner {
                padding: 2% 15%;
            }
        </style>
    </div>
</body>

</html>
