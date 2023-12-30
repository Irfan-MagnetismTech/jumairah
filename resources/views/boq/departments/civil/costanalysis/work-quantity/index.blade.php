@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Work Quantity')
@section('project-name')
    <a href="#" style="color:white;">{{ $project->name }}</a>
@endsection

@section('content-grid', 'col-12')

@section('content')
    <style>
        tbody tr,
        td {
            text-align: left;
        }

        tbody td {
            margin-left: 5px;
        }

        .table2 tr,td {
            border: 1px solid gray !important;
        }
    </style>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3">
                    <h4>Project name - {{ $project->name }}</h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="text-align: center;display: flex;justify-content: space-between;align-items: center">
                    <h5>Work Wise Quantity</h5>
                    <a target="_blank" href="{{ route('boq.project.departments.civil.cost_analysis.download.work.quantity.pdf', ['project' => $project]) }}" data-toggle="tooltip" title="" class="btn btn-outline-danger" data-original-title="Download PDF"><i class="fas fa-file-pdf"></i></a>
                </td>
            </tr>
        </tbody>
    </table>

    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-3 px-1 my-1 my-md-0" data-toggle="tooltip" title="Project Status">
                <select name="work_id" class="form-control form-control-sm" autocomplete="off">
                    <option value="" disabled selected>Select Work</option>
                    @foreach ($allWorks as $key => $boqCivilBudget)
                        <option value="{{ $key }}" {{ request('work_id') == $key ? 'selected' : '' }}>
                            {{ $boqCivilBudget['work_items'] ? $boqCivilBudget['work_items']->first()->boqCivilCalcWork->name : 'Work Name Not Available' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <table class="table table-bordered table2">
        <thead>
        <tr>
            <th>SL.</th>
            <th>Work Name</th>
            <th>Unit</th>
            <th>Location</th>
            <th>Quantity</th>
            <th>Total Quantity</th>
        </tr>
        </thead>
        <tbody>
            <?php $headWiseTotalAmount = 0;
            $sl = 1; ?>
            @foreach ($boqCivilBudgets as $key => $boqCivilBudget)
                @foreach ($boqCivilBudget['work_items'] as $miniKey => $boqCivilBudgetItem)
                    @if($sl % 2 == 0)
                        <?php $row_bg_color = '#f0efed'; ?>
                    @else
                        <?php $row_bg_color = '#c9c7c1'; ?>
                    @endif

                    <tr style="background-color: {{ $row_bg_color }};">
                        @if ($loop->first)
                            <td style="font-weight: bold" rowspan="{{ $loop->first ? count($boqCivilBudget['work_items']) : '' }}" class="text-center">
                                @if ($loop->first)
                                    {{ $sl }}
                                @endif
                            </td>
                            <td style="font-size: 12px" rowspan="{{ $loop->first ? count($boqCivilBudget['work_items']) : '' }}"
                                class="font-weight-bold text-center">
                                @if ($loop->first)
{{--                                    {{ $boqCivilBuget?->first()->boqCivilCalcProjectFloor?->floor?->name }}--}}
                                    {{ $boqCivilBudget['work_items']?->first()->boqCivilCalcWork?->name }}
                                @endif
                            </td>
                            <td style="font-size: 12px" rowspan="{{ $loop->first ? count($boqCivilBudget['work_items']) : '' }}"
                                class="font-weight-bold text-center">
                                @if ($loop->first)
                                    {{ $boqCivilBudget['work_items']?->first()->boqCivilCalcWork?->boqWorkUnit?->name }}
                                @endif
                            </td>
                        @endif
                        <td style="font-weight: bold">
                            {{ $boqCivilBudgetItem?->boqCivilCalcProjectFloor?->floor?->name }}
                        </td>
                        <td style="font-weight: bold;font-size: 12px">
                            <span class="float-right">@money($boqCivilBudgetItem?->total)</span>
                        </td>
                            @if ($loop->first)
                                <td style="font-size: 12px" rowspan="{{ $loop->first ? count($boqCivilBudget['work_items']) : '' }}"
                                    class="font-weight-bold text-center">
                                    @if ($loop->first)
                                        @money($boqCivilBudget['total_quantity'])
                                    @endif
                                </td>
                            @endif
                    </tr>
                @endforeach
                <?php $sl++; ?>
            @endforeach
        </tbody>
    </table>
@endsection
