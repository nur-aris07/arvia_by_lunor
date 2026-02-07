
<div class="py-4 px-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-neutral-800 to-neutral-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div>
            <p class="font-semibold text-gray-900 leading-tight truncate">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">ID: #{{ $user->id }}</p>
        </div>
    </div>
</div>