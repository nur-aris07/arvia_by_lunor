<div class="py-4 px-6">
    @if($user->invitation)
        <a href="{{ route('admin.invitations.show', $user->invitation->id) }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-check-circle"></i> Ada
        </a>
    @else
        <span class="text-gray-400">
            <i class="fas fa-minus-circle"></i> Belum
        </span>
    @endif
</div>