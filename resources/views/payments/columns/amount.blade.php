<div class="py-4 px-6 text-right">
    <div class="text-sm font-semibold text-gray-900">
        Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}
    </div>
    @if(!empty($payment->notes))
        <div class="text-xs text-gray-500 line-clamp-1">{{ $payment->notes }}</div>
    @endif
</div>