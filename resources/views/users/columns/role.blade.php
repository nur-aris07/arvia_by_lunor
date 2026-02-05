<div class="py-4 px-6">
    <span class="px-3 py-1 rounded-full text-xs font-medium
        @if($user->role === 'admin') bg-purple-100 text-purple-700
        @else bg-blue-100 text-blue-700
        @endif">
        {{ ucfirst($user->role) }}
    </span>
</div>