<!DOCTYPE html>
<html>

<head>

</head>

<body>


    <table style="width: 100%" id="categoryWiseTable">
        <thead>
            <tr>
                <td colspan="8" style="text-align: center; font-weight: bold; font-size: 20px">
                    Category Wise Lead Generation Report ({{ $month }}/{{ $year }})
                </td>
            </tr>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td>Category</td>
                <td>#</td>
                <td>Customer Name </td>
                <td>Project</td>
                <td> Apt No/Floor </td>
                <td> Apt Size (sft.) </td>
                <td> Company Offer </td>
                <td> Client Offer </td>
                <td> Remarks </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($category_wise_leads as $key => $category_wise_leads)
            <tr>
                <td rowspan="{{ count($category_wise_leads) + 1 }}" style="text-align: center; font-weight: bold">
                    {{ $key }}
                </td>

                @foreach ($category_wise_leads as $lead)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->apartment->project->name }}</td>
                <td>{{ $lead->apartment->floor }}</td>
                <td>{{ $lead->apartment->apartment_size }}</td>
                <td></td>
                <td></td>
                <td>{{ $lead->lastFollowup->remarks ?? '' }}</td>
            </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>