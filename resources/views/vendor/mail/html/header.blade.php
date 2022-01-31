<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ mix('favicon.png', '/assets/vendor/boilerplate') }}" class="logo" alt="BDPay">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
