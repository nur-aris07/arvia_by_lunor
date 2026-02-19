<div class="py-4 px-6">
    @if($payment->paid_at)
        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</div>
        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->paid_at)->format('H:i') }} • paid</div>
    @else
        <div class="text-sm text-gray-900">{{ $payment->created_at?->format('d M Y') }}</div>
        <div class="text-xs text-gray-500">{{ $payment->created_at?->format('H:i') }} • created</div>
    @endif
</div>