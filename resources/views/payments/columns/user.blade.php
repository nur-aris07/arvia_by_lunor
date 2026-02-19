@php
    $u = $payment->invitation?->user;
    $initials = $u?->name ? strtoupper(substr($u->name, 0, 2)) : 'NA';
@endphp

<div class="py-4 px-6">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-zinc-700 to-zinc-800 flex items-center justify-center text-white text-xs font-semibold">{{ $initials }}</div>
        <div class="min-w-0">
            <div class="text-sm font-medium text-gray-900 truncate">{{ $u?->name ?? '-' }}</div>
            <div class="text-xs text-gray-500 truncate">{{ $u?->email ?? '-' }}</div>
        </div>
    </div>
</div>