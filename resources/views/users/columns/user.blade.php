
<div class="py-4 px-6">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div>
            <p class="font-medium text-gray-900">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">ID: #{{ $user->id }}</p>
        </div>
    </div>
</div>