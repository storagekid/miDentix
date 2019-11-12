@component('mail::message')
# Clinic:
<ul>
  <li>Name: <strong>{{ $clinic->nickname }}</strong></li>
  <li>Open: <strong>@if($clinic->open)<span style="color:green">Yes</span>@else<span style="color:red">No</span>@endif</strong></li>
  <li>Active: <strong>@if($clinic->active)<span style="color:green">Yes</span>@else<span style="color:red">No</span>@endif</strong></li>
  <li>Starts At: <strong>{{ $clinic->starts_at }}</strong></li>
  <li>Ends At: <strong>{{ $clinic->ends_at }}</strong></li>
</ul>
# Campaign:<br>
<ul>
  <li>Name: <strong>{{ $campaign->name }}</strong></li>
  <li>Starts At: <strong>{{ $campaign->starts_at }}</strong></li>
  <li>Ends At: <strong>{{ $campaign->ends_at }}</strong></li>
</ul>
# Clinic Poster:<br>
<ul>
  <li>Size: <strong>{{ $clinicPoster->poster->name }}</strong></li>
  <li>Priority: <strong>{{ $clinicPoster->priority }}</strong></li>
  <li>Campaign Priority: <strong>{{ $campaignPriority }}</strong></li>
  <li>Language: <strong>{{ $clinic->language->iso_name }}</strong></li>
  <li>Original Type: <strong>{{ $clinicPoster->type }}</strong></li>
  <li>Computed Type: <strong>{{ $computedType }}</strong></li>
</ul>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
