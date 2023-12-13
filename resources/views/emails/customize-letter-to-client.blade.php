@component('mail::message')
<div class="row">
    <div class="col-xl-1 col-md-1"></div>
    <div class="col-xl-6 col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <h6>Date  {{ $CsdLetterMail->letter_date }}</h6>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-1 col-md-1"></div>
    <div class="col-xl-6 col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <h6>To</h6>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-1 col-md-1"></div>
    <div class="col-xl-8 col-md-8">
        <div class="input-group input-group-sm input-group-primary">
            {{ $CsdLetterMail->address_word_one }} &nbsp;{{ $CsdLetterMail->client->name }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-1 col-md-1"></div>
    <div class="col-xl-6 col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            {{ $CsdLetterMail->client->present_address }}
        </div>
    </div>
</div><br>

<div class="row">
    <div class="col-xl-1 col-md-1"></div>
    <div class="col-xl-8 col-md-8">
        <div class="input-group input-group-sm input-group-primary">
            <b>Subject: {{ $CsdLetterMail->letter_subject }}</b>
        </div>
    </div>
</div><br>

<div class="row">
    <div class="col-xl-1 col-md-1"></div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <h6 class="form-control" style="border: none">Dear {{ $CsdLetterMail->address_word_two }},</h6>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-2 col-md-2"></div>
    <div class="col-xl-9 col-md-9">
        <div class="input-group input-group-sm input-group-primary">
            <span style="word-break:break-all; text-align:justify">{!! $CsdLetterMail->letter_body !!}</span>
        </div>
    </div>
</div><br><br><br><br>
<div class="row">
    <div class="col-xl-2 col-md-2"></div>
    <div class="col-xl-4 col-md-4">
        <table>
            <tr>
                <td>
                    <span>Thanking You,</span><br><br><br>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-xl-2 col-md-2"></div>
    <div class="col-xl-4 col-md-4">
        <table>
            <tr>
                <td>
                    <span>Manager</span><br>
                    <span>Customer Service Department</span><br>
                    <span>Jumairah Limited</span>
                </td>
            </tr>
        </table>
    </div>
</div><br><br><br>

@endcomponent
