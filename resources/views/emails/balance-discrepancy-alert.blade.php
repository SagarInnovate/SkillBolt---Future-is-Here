@component('mail::message')
# URGENT: Balance Discrepancy Detected

A discrepancy has been detected in the affiliate balance for user **{{ $user->name }}** (ID: {{ $user->id }}).

**Stored Balance:** ₹{{ number_format($storedBalance, 2) }}  
**Calculated Balance:** ₹{{ number_format($calculatedBalance, 2) }}  
**Difference:** ₹{{ number_format($calculatedBalance - $storedBalance, 2) }}

This may indicate unauthorized manipulation of account data or a system error.

@component('mail::button', ['url' => url("/admin/affiliate/affiliates/{$user->id}")])
View User
@endcomponent

Please investigate this issue immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent