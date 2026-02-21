<div class="py-4 px-6">
    <div class="flex items-center justify-center space-x-2">
        <a href="javascript:void(0)" class="detail-btn w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition" title="Detail" data-id="{{ $user->hash_id }}">
            <i class="fas fa-eye text-[14px]"></i>
        </a>
        <a href="javascript:void(0)" class="edit-btn w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-amber-600 hover:bg-amber-50 hover:border-amber-200 transition" title="Edit" data-id="{{ $user->hash_id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-phone="{{ $user->phone }}" data-role="{{ $user->role }}">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <button type="button" 
                class="reset-password-btn w-9 h-9 inline-flex items-center justify-center rounded-xl  bg-gray-50 border border-gray-200/70 text-purple-600  hover:bg-purple-50 hover:border-purple-200 transition" 
                title="Reset Password" 
                data-id="{{ $user->hash_id }}">
            <i class="fas fa-sync-alt"></i>
        </button>
        {{-- @if(!$user->invitation)
            <a href="{{ route('admin.invitations.create', ['user_id' => $user->id]) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Buat Undangan">
                <i class="fas fa-plus-circle"></i>
            </a>
        @endif --}}
        @if($user->role === 'user')
            <button type="button" class="delete-btn w-9 h-9 inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200/70 text-red-600 hover:bg-red-50 hover:border-red-200 transition" title="Hapus" data-id="{{ $user->hash_id }}">
                <i class="fas fa-trash-alt"></i>
            </button>
        @endif
    </div>
</div>