@component('mail::message')

Received with Thanks from {{$salesCollection->sell->sellClient->client->name}},
amount of Tk. {{$salesCollection->received_amount}}/- (Taka {{$salesCollection->receivedAmountInwords}} Only),
through {{$salesCollection->payment_mode}}, Dated on – {{$salesCollection->received_date}},
Purpose-
@foreach($salesCollection->salesCollectionDetails as $salesCollectionDetail)
    {{$salesCollectionDetail->particular}}
    {{$salesCollectionDetail->installment_no ? "-$salesCollectionDetail->installment_no" : null}}
@endforeach

<table>
    <tr> <td> Project Name </td> <td>:</td> <td><strong>{{$salesCollection->sell->apartment->project->name}}</strong></td></tr>
    <tr> <td> Location </td> <td>:</td> <td><strong>{{$salesCollection->sell->apartment->project->location}}</strong></td></tr>
    <tr> <td> Apartment ID </td> <td>:</td> <td><strong>{{$salesCollection->sell->apartment->name}}</strong></td></tr>
    <tr> <td> Apartment Size </td> <td>:</td> <td><strong>{{$salesCollection->sell->apartment_size}}</strong> SFT (approx.).</td></tr>
</table>
<p></p>

@endcomponent
