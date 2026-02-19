<div class="py-4 px-6">
    <div class="font-medium text-gray-900">{{ $payment->invitation?->title ?? '-' }}</div>
    <div class="text-sm text-gray-500">{{ $payment->invitation?->slug ?? '-' }}</div>
</div>