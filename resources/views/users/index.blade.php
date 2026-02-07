@extends('layouts.app')

@section('title', 'Daftar User')
@section('header', 'Manajemen User')
@section('context', 'User')


@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input id="search" type="text" placeholder="Cari user..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none"></i>
            </div>
            <select id="filter-role" class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <option value="">Semua Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <a href="/users/add" class="px-3 py-2 bg-neutral-900 text-white rounded-xl hover:bg-neutral-800 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Tambah User</span>
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-gray-200/70 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="table" class="w-full">
                <thead class="bg-gray-50/70 border-b border-gray-200/70">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/70"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Hapus @yield('context')</h3>
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus data ini? Semua data terkait akan ikut terhapus.</p>
        <div class="flex justify-end space-x-3">
            <button type="button" id="deleteModalBatalBtn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            paging: true,
            info: true,
            lengthChange: false,
            autoWidth: false,
            pageLength: 5,
            dom: 'rt<"dt-footer flex w-full items-center justify-between px-6 py-4 border-t border-gray-200"ip>',
            ajax: {
                url: "{{ route('users.index') }}",
                data: function (d) {
                    d.search = $('#search').val();
                    d.role = $('#filter-role').val();
                }
            },
            columns: [
                { data: 'user', name: 'user', orderable: true },
                { data: 'contact', name: 'contact', orderable: true },
                { data: 'role', name: 'role', orderable: true, searchable: false },
                { data: 'action', orderable: false, searchable: false },
            ],
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ results",
                infoEmpty: "Showing 0 to 0 of 0 results",
                emptyTable: `
                    <div class="py-12 text-center text-gray-500">
                        <p>Tidak Ada Data Ditemukan</p>
                    </div>
                `,
                paginate: {
                    previous: '<i class="fas fa-chevron-left"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                }
            }
        });

        function debounce(fn, delay = 350) {
            let t;
            return function (...args) {
                clearTimeout(t);
                t = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        $('#search').on('input', debounce(function () {
            table.draw();
        }, 350));

        $('#filter-role').on('change', function () {
            table.draw();
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const batalBtn = document.getElementById('deleteModalBatalBtn');

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.delete-btn');
            if (!btn) return;

            const userId = btn.dataset.id;

            form.action = `/users/${userId}/delete`;
            modal.classList.remove('hidden');
        });

        batalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            form.action = '';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                form.action = '';
            }
        });
    });
</script>
@endsection