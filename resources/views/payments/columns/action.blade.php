<div class="py-4 px-6">
    <div class="flex items-center justify-center gap-2">
        <a href="" class="w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition" title="Detail">
        <i class="fas fa-eye text-[14px]"></i>
        </a>

        @if(is_null($payment->paid_at))
        <button type="button" class="pay-mark w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200 transition" title="Tandai Lunas" data-id="{{ $payment->hash_id }}" data-status="paid">
            <i class="fas fa-check text-[14px]"></i>
        </button>
        @else
        <button type="button" class="pay-mark w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-amber-600 hover:bg-amber-50 hover:border-amber-200 transition" title="Batalkan Pembayaran" data-id="{{ $payment->hash_id }}" data-status="unpaid">
            <i class="fas fa-undo text-[14px]"></i>
        </button>
        @endif

        <button type="button" class="invoice-print w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-purple-600 hover:bg-purple-50 hover:border-purple-200 transition" title="Print Invoice" data-id="{{ $payment->hash_id }}">
        <i class="fas fa-print text-[14px]"></i>
        </button>
    </div>
</div>
