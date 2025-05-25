@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/logo_8.png') }}" class="logo" alt="PeakForm Logo" style="height: 50px;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
