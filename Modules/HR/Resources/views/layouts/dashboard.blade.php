@can('hr')
    <h5 class="m-b-10">HR</h5>
    <br>
    <div class="row">
        @can('employee-show')
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Employee</h6>
                        <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $data['hr_data']['total_employee'] }}</span>
                        </h2>
                    </div>
                </div>
            </div>
        @endcan
        @can('department-show')
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Department</h6>
                        <h2 class="text-right"><i
                                class="ti-layout-grid3 f-left"></i><span>{{ $data['hr_data']['total_department'] }}</span>
                        </h2>
                    </div>
                </div>
            </div>
        @endcan
        @can('designation-show')
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Designation</h6>
                        <h2 class="text-right"><i
                                class="ti-widgetized f-left"></i><span>{{ $data['hr_data']['total_designation'] }}</span>
                        </h2>
                    </div>
                </div>
            </div>
        @endcan
        @can('job-location-show')
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Job Location</h6>
                        <h2 class="text-right"><i
                                class="ti-location-pin f-left"></i><span>{{ $data['hr_data']['total_joblocation'] }}</span>
                        </h2>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <div class="row">
        <div id="attendance_chart" class="col-md-6">
        </div>
        <div class="col-md-6" id='department_wise_employees_chart'>

        </div>
    </div>

@endcan
@section('script')
    <script>
        @can('employee-show')
            @php
                $department_wise_employees = collect($data['hr_data']['department_wise_employees']);
                $departments = json_encode($department_wise_employees->pluck('department_name'));
                $employee_count_in_departments = json_encode($department_wise_employees->pluck('total_employee'));
            @endphp



            var department_wise_employees_chart_options = {
                series: {!! $employee_count_in_departments !!},
                chart: {
                    width: 650,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'gradient',
                },

                labels: {!! $departments !!},
                title: {
                    text: 'Department Wise Employee',
                    align: 'center',
                },
                responsive: [{
                    breakpoint: 580,
                    options: {
                        chart: {
                            width: 480
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#department_wise_employees_chart"), department_wise_employees_chart_options);
            chart.render();
        @endcan

        @can('show-attendance')

            @php
                $attendance_days = json_encode(collect($data['hr_data']['attendance_presence_data'])->pluck('date'));
                $attendance_presence_data = json_encode(collect($data['hr_data']['attendance_presence_data'])->pluck('total_presence'));
                $attendance_absence_data = json_encode(collect($data['hr_data']['attendance_absence_data'])->pluck('total_absence'));
            @endphp
            var attendance_presence_data_options = {
                series: [{
                    name: 'Presence',
                    data: {!! $attendance_presence_data !!}
                }, {
                    name: 'Absence',
                    data: {!! $attendance_absence_data !!}
                }, ],
                chart: {
                    type: 'bar',
                    height: 400,

                },
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: {!! $attendance_days !!},
                    title: {
                        text: 'Last 7 Day Attendance'
                    }
                }
            };

            var attendance_chart = new ApexCharts(document.querySelector("#attendance_chart"),
                attendance_presence_data_options);
            attendance_chart.render();
        @endcan
    </script>
@endsection
