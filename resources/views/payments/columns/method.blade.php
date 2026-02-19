@php
    $method = $payment->payment_method ?? '-';
@endphp

<div class="py-4 px-6">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
        {{ strtoupper($method) }}
    </span>
</div>