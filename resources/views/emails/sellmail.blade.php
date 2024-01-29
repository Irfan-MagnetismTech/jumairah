@component('mail::message')
Ref: RFPL/CSD/R.Prayash/{{now()->format('Y-d')}} <br>
{{now()->format('F d, Y')}}

<strong>{{$sell->sellclient->client->name}}</strong> <br>
{{$sell->sellclient->client->present_address}} <br>

<p>
    Dear Sir,<br>
    On behalf of {!! htmlspecialchars(config('company_info.company_fullname')) !!} I would like to take this opportunity to congratulate you as the new member of {!! htmlspecialchars(config('company_info.company_name')) !!} family by booking an apartment from our project.
<p>

<table>
    <tr> <td> Project Name </td> <td>:</td> <td><strong>{{$sell->apartment->project->name}}</strong></td></tr>
    <tr> <td> Location </td> <td>:</td> <td><strong>{{$sell->apartment->project->location}}</strong></td></tr>
    <tr> <td> Apartment ID </td> <td>:</td> <td><strong>{{$sell->apartment->name}}</strong></td></tr>
    <tr> <td> Apartment Size </td> <td>:</td> <td><strong>{{$sell->apartment->apartment_size}}</strong> SFT (approx.).</td></tr>
</table>
<p></p>
<p>
Please be informed that from now on <strong>“Customer Service Department”</strong> will contact with you to provide all sorts of information regarding project work progress, payment of monthly installment, allotment letter, deed of agreement, modification/optional work status, apartment handover, bank loan facilities, registration, shifting, name transfer, cancellation, after sales service etc. and will also prepare all other apartment related documents.
</p>

<p>For any query you are cordially requested to contact with the <strong>Customer Service Department</strong>.</p>

<p>Thanking you in advance for your kind co-operation.</p>


<p>
    With best regards, <br>
    <strong>Md. Imtiaz Bashar</strong> <br>
    DM- Customer Service <br>
    Cell : 01713-142013
</p>
@endcomponent
