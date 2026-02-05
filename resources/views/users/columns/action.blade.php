<div class="py-4 px-6">
    <div class="flex items-center justify-center space-x-2">
        <a href="" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition" title="Detail">
            <i class="fas fa-eye"></i>
        </a>
        <a href="" class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition" title="Edit">
            <i class="fas fa-pencil-alt"></i>
        </a>
        {{-- @if(!$user->invitation)
            <a href="{{ route('admin.invitations.create', ['user_id' => $user->id]) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Buat Undangan">
                <i class="fas fa-plus-circle"></i>
            </a>
        @endif --}}
        @if($user->role === 'admin')
            <button onclick="confirmDelete({{ $user->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Hapus">
                <i class="fas fa-trash-alt"></i>
            </button>
        @endif
    </div>
</div>