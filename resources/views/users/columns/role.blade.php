<div class="py-4 px-6">
  @php $isAdmin = $user->role === 'admin'; @endphp

  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
               border
               {{ $isAdmin
                  ? 'bg-indigo-50 text-indigo-700 border-indigo-200'
                  : 'bg-gray-50 text-gray-700 border-gray-200' }}">
    {{ ucfirst($user->role) }}
  </span>
</div>