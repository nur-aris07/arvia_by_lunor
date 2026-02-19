@php
    $paid = !is_null($payment->paid_at);
@endphp

<div class="py-4 px-6 text-center">
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
        {{ $paid ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
        <i class="fas {{ $paid ? 'fa-check-circle' : 'fa-clock' }}"></i>
        {{ $paid ? 'Lunas' : 'Pending' }}
    </span>
</div>
