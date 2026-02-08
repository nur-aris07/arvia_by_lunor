@php $p = strtolower($invitation->payment_status ?? 'unpaid'); @endphp

<div class="py-4 px-6 flex justify-center">
    @if($p === 'paid')
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                     bg-emerald-50 text-emerald-700 border border-emerald-200">
            <i class="fas fa-check-circle text-emerald-600"></i>
            Lunas
        </span>
    @else
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                     bg-red-50 text-red-700 border border-red-200">
            <i class="fas fa-exclamation-circle text-red-600"></i>
            Belum Bayar
        </span>
    @endif
</div>
