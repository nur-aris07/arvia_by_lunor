@php
  $nm = $invitation->user->name ?? '-';
  $initial = strtoupper(mb_substr($nm, 0, 2));
@endphp

<div class="py-4 px-6">
    <div class="flex items-center gap-3 min-w-0">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-neutral-800 to-neutral-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
            {{ $initial }}
        </div>
        <div class="min-w-0">
            <p class="text-sm text-gray-900 leading-tight truncate">
                {{ $invitation->user->name ?? '-' }}
            </p>
            <p class="text-xs text-gray-900 leading-tight truncate">
                {{ $invitation->user->email ?? '-' }}
            </p>
        </div>
    </div>
</div>
