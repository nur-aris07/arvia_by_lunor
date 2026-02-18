@extends('layouts.app')

@section('title', 'Daftar Undangan')
@section('header', 'Manajemen Undangan')
@section('context', 'Undangan')

@section('content')
<div class="space-y-6">
    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Undangan Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Draft</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['draft'] ?? 0 }}</p>
                </div>
                <i class="fas fa-edit text-yellow-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Belum Bayar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['unpaid'] ?? 0 }}</p>
                </div>
                <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Arsip</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['archived'] ?? 0 }}</p>
                </div>
                <i class="fas fa-archive text-gray-500 text-2xl"></i>
            </div>
        </div>
    </div>
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input id="search" type="text" placeholder="Cari undangan..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
            </div>
            <select id="filter-status" class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="active">Aktif</option>
                <option value="archived">Arsip</option>
            </select>
            <select id="filter-payment" class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                <option value="">Semua Pembayaran</option>
                <option value="unpaid">Belum Bayar</option>
                <option value="paid">Sudah Bayar</option>
            </select>
        </div>
        <a href="javascript:void(0)" id="btnAdd" class="px-4 py-2 px-3 py-2 bg-neutral-900 text-white rounded-xl hover:bg-neutral-800 transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus"></i>
            <span>Undangan</span>
        </a>
    </div>

    <!-- Invitations Table -->
    <div class="bg-white rounded-2xl border border-gray-200/70 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="table" class="w-full">
                <thead class="bg-gray-50/70 border-b border-gray-200/70">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Undangan</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Template</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Pembayaran</th>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat</th>
                        <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/70"></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalAdd" class="hidden fixed inset-0 z-[9998]">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl border border-gray-200/70 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200/70 flex items-center justify-between">
                <div>
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Tambah @yield('context')</h3>
                    <p id="modalSub" class="text-sm text-gray-500">Isi data dengan benar.</p>
                </div>
                <button type="button" id="modalCloseAdd" class="h-9 w-9 rounded-xl inline-flex items-center justify-center text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <form id="modalFormAdd" class="px-5 pb-3 flex flex-col flex-1 overflow-hidden" action="/invitations/add" method="POST">
                @csrf
                <div class="body-modal max-h-[60vh] overflow-y-auto pr-1 scroll-nice space-y-1.5">
                    <input type="hidden" id="idAdd" name="id" value="" />
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input id="titleAdd" name="title" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none" placeholder="Title Undangan" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input id="slugAdd" name="slug" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" placeholder="otomatis dari title" readonly required>
                        <p class="ml-3 mt-1 text-xs text-gray-500">Slug dibuat otomatis dari Title Undangan.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select id="userAdd" name="user" class="ts-remote" data-lookup-url="{{ route('invitations.lookup') }}" data-type="users" data-placeholder="Cari user..." data-dropdown-title="Pilih User">
                            @isset($selectedUser)
                                <option value="{{ $selectedUser->id }}" selected>{{ $selectedUser->name }} — {{ $selectedUser->email }}</option>
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                        <select id="templateAdd" name="template" class="ts-remote" data-lookup-url="{{ route('invitations.lookup') }}" data-type="templates" data-placeholder="Cari template...">
                            @isset($selectedTemplate)
                                <option value="{{ $selectedTemplate->id }}" selected>{{ $selectedTemplate->name }} — Rp {{ number_format($selectedTemplate->price ?? 0, 0, ',', '.') }}</option>
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="modalCancelAdd" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="formSubmitAdd" class="px-3 py-2 rounded-xl bg-neutral-900 text-white hover:bg-neutral-800 transition inline-flex items-center gap-2">
                        <span id="formSubmitTextAdd">Simpan</span>
                        <i id="formSpinnerAdd" class="fas fa-circle-notch fa-spin hidden"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalEdit" class="hidden fixed inset-0 z-[9998]">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl border border-gray-200/70 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200/70 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Edit @yield('context')</h3>
                    <p class="text-sm text-gray-500">Perbarui data dengan benar.</p>
                </div>
                <button type="button" id="modalCloseEdit" class="h-9 w-9 rounded-xl inline-flex items-center justify-center text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <form id="modalFormEdit" action="/invitations/update" method="POST" class="px-5 pb-3 flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="body-modal max-h-[60vh] overflow-y-auto pr-1 scroll-nice space-y-1.5"> 
                    <input type="hidden" id="idEdit" name="id">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input id="titleEdit" name="title" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none" placeholder="Title Undangan" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input id="slugEdit" name="slug" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" readonly required>
                        <p class="ml-3 mt-1 text-xs text-gray-500">
                            Slug dibuat otomatis dari Title Undangan.
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select id="userEdit" name="user" class="ts-remote" data-lookup-url="{{ route('invitations.lookup') }}" data-type="users" data-placeholder="Cari user..." data-dropdown-title="Pilih User">
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                        <select id="templateEdit" name="template" class="ts-remote" data-lookup-url="{{ route('invitations.lookup') }}" data-type="templates" data-placeholder="Cari template...">
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="statusAdd" name="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none">
                            <option value="1">Active</option>
                            <option value="0">Non Active</option>
                        </select>
                    </div>
                </div>
                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" id="modalCancelEdit" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>

                    <button type="submit" id="formSubmitEdit" class="px-3 py-2 rounded-xl bg-neutral-900 text-white hover:bg-neutral-800 transition inline-flex items-center gap-2">
                        <span id="formSubmitTextEdit">Update</span>
                        <i id="formSpinnerEdit" class="fas fa-circle-notch fa-spin hidden"></i>
                    </button>
                </div>
            </form>
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
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus undangan ini? Semua data terkait akan ikut terhapus.</p>
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

@push('scripts')
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
                    url: "{{ route('invitations.index') }}",
                    data: function (d) {
                        d.search = $('#search').val();
                        d.status = $('#filter-status').val();
                        d.payment = $('#filter-payment').val();
                    }
                },
                columns: [
                    { data: 'undangan', name: 'undangan', orderable: true },
                    { data: 'user', name: 'user', orderable: true },
                    { data: 'template', name: 'template', orderable: true, },
                    { data: 'status', name: 'status', orderable: true, },
                    { data: 'payment', name: 'payment', orderable: true, },
                    { data: 'created', name: 'created', orderable: true, },
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

            $('#filter-status').on('change', function () {
                table.draw();
            });

            $('#filter-payment').on('change', function () {
                table.draw();
            });
        });

        (function () {
            function buildTomSelect(el) {
            if (!el || !window.TomSelect) return;

            const url = el.dataset.lookupUrl;
            const type = el.dataset.type;
            const placeholder = el.dataset.placeholder || 'Cari...';
            const dropdownTitle = el.dataset.dropdownTitle || 'Pilih';

            if (el.tomselect) el.tomselect.destroy();

                const ts = new TomSelect(el, {
                    valueField: 'id',
                    labelField: 'label',
                    searchField: ['label', 'meta'],
                    preload: 'focus',
                    maxOptions: 30,
                    create: false,
                    placeholder,
                    plugins: ['dropdown_input'],
                    dropdownParent: 'body',
                    closeAfterSelect: true,
                    openOnFocus: true,
                    shouldLoad: function (query) {
                        return true;
                    },
                    loadThrottle: 200,

                    render: {
                        option: function (data, escape) {
                            const label = escape(data.label ?? '');
                            const meta  = escape(data.meta ?? '');
                            return `
                            <div class="ts-opt">
                                <div class="ts-opt-label">${label}</div>
                                ${meta ? `<div class="ts-opt-meta">${meta}</div>` : ''}
                            </div>
                            `;
                        },
                        item: function (data, escape) {
                            return `<div>${escape(data.label ?? '')}</div>`;
                        },
                        no_results: () => `<div class="p-3 text-sm text-gray-500">Tidak ada hasil</div>`,
                        loading: () => `<div class="p-3 text-sm text-gray-500">Memuat...</div>`,
                    },

                    load: function (query, callback) {
                        try {
                            const u = new URL(url, window.location.origin);
                            u.searchParams.set('type', type);
                            u.searchParams.set('q', query || '');

                            fetch(u.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                                .then(r => r.json())
                                .then(json => {
                                    this.clearOptions();
                                    callback(json);
                                    this.refreshOptions(false);
                                })
                                .catch(() => callback());
                        } catch (e) {
                            callback();
                        }
                    },
                    onDropdownOpen: function () {
                        fitDropdownToViewport(this);
                    },
                    onType: function () {
                        fitDropdownToViewport(this);
                    },
                });
                
                const reFit = () => fitDropdownToViewport(ts);
                window.addEventListener('resize', reFit);
                window.addEventListener('scroll', reFit, true);

                ts.on('type', function (str) {
                    if (str === '') {
                        ts.load('', () => {});
                    }
                });
            }

            function fitDropdownToViewport(instance){
                const dd = instance.dropdown;
                const content = dd.querySelector('.ts-dropdown-content');
                const controlRect = instance.control.getBoundingClientRect();

                const viewportTop = 8;
                const viewportBottom = window.innerHeight - 8;

                const spaceBelow = viewportBottom - controlRect.bottom;
                const spaceAbove = controlRect.top - viewportTop;

                const fixed = 44 + 56 + 12;
                const minList = 140;
                const maxListDefault = 260;

                dd.style.left = controlRect.left + 'px';
                dd.style.width = controlRect.width + 'px';
                dd.style.top = '';
                dd.style.bottom = '';

                const canOpenDown = (spaceBelow - fixed) >= minList;
                const openUp = !canOpenDown && spaceAbove > spaceBelow;

                if (openUp) {
                    dd.style.top = (controlRect.top + window.scrollY) + 'px';
                    dd.style.transform = 'translateY(-100%)';
                    const maxList = Math.max(minList, Math.min(maxListDefault, spaceAbove - fixed));
                    if (content) content.style.maxHeight = maxList + 'px';
                } else {
                    dd.style.top = (controlRect.bottom + window.scrollY) + 'px';
                    dd.style.transform = 'translateY(0)';
                    const maxList = Math.max(minList, Math.min(maxListDefault, spaceBelow - fixed));
                    if (content) content.style.maxHeight = maxList + 'px';
                }
            }

            function initAllTomSelect() {
                document.querySelectorAll('select.ts-remote').forEach(buildTomSelect);
            }
            document.addEventListener('DOMContentLoaded', initAllTomSelect);
            window.initTomSelectRemote = initAllTomSelect;
        })();

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const batalBtn = document.getElementById('deleteModalBatalBtn');

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.delete-btn');
                if (!btn) return;

                const userId = btn.dataset.id;

                form.action = `/invitations/${userId}/delete`;
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
            
            const btnAdd = document.getElementById('btnAdd');
            const modalAdd = document.getElementById('modalAdd');
            const btnCloseModalAdd = document.getElementById('modalCloseAdd');
            const btnCancelModalAdd = document.getElementById('modalCancelAdd');
            const modalEdit = document.getElementById('modalEdit');
            const btnCloseModalEdit = document.getElementById('modalCloseEdit');
            const btnCancelModalEdit = document.getElementById('modalCancelEdit');

            function openModal(m) {
                m.classList.remove('hidden');
                if (window.initTomSelectRemote) window.initTomSelectRemote();
            }
            function closeModal(m) {
                m.classList.add('hidden');
                // setLoading(false);
            }

            btnCloseModalAdd.addEventListener('click', () => closeModal(modalAdd));
            btnCancelModalAdd.addEventListener('click', () => closeModal(modalAdd));
            btnCloseModalEdit.addEventListener('click', () => closeModal(modalEdit));
            btnCancelModalEdit.addEventListener('click', () => closeModal(modalEdit));
            if (btnAdd) {
                btnAdd.addEventListener('click', () => {
                    openModal(modalAdd);
                });
            }
            document.addEventListener('click', (e) => {
                
                const btn = e.target.closest('.edit-btn');
                if (!btn) return;
                const data = btn.closest('[data-id]');
                if (!data) return;
                openModal(modalEdit);
                
                const dataset = data.dataset;
                Object.keys(dataset).forEach((key) => {
                    let value = dataset[key];
                    try {
                        value = JSON.parse(value);
                    } catch(error) {}
                    const input = document.querySelector(`#${key}Edit`);
                    if (!input) return;
                    if (input) {
                        input.value = typeof value === 'object' && value !== null
                            ? JSON.stringify(value, null, 2)
                            : value;
                    }

                    if (input.classList.contains('ts-remote') && input.tomselect) {
                        const ts = input.tomselect;
                        ts.clear();

                        if (value && typeof value === 'object') {
                            ts.addOption(value);
                            ts.addItem(value.id);
                        }
                        return;
                    }
                    
                    input.value = value ?? '';
                });
            });
        });
    </script>
@endpush
<script>
function updatePayment(invitationId, status) {
    if (confirm('Tandai pembayaran sebagai lunas?')) {
        fetch(`/admin/invitations/${invitationId}/payment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ payment_status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection