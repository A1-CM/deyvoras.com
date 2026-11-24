<h1>New Deyvoras website enquiry</h1>
<p><strong>Name:</strong> {{ $inquiry['name'] }}</p>
<p><strong>Email:</strong> {{ $inquiry['email'] }}</p>
@if (!empty($inquiry['organization']))<p><strong>Organization:</strong> {{ $inquiry['organization'] }}</p>@endif
<p><strong>Subject:</strong> {{ $inquiry['subject'] }}</p>
<hr>
<p>{!! nl2br(e($inquiry['message'])) !!}</p>
