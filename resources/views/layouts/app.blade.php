<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html, body { height: 100%; }
        body { overflow: hidden; }
        main, nav { scrollbar-gutter: stable; }
        nav, main { overscroll-behavior: contain; }
        
        .scroll-nice{
            scrollbar-width: thin;
            scrollbar-color: rgba(148,163,184,.85) transparent;
        }
        .scroll-nice::-webkit-scrollbar{ width: 10px; height: 10px; }
        .scroll-nice::-webkit-scrollbar-track{ background: transparent; }
        .scroll-nice::-webkit-scrollbar-thumb{
            background: rgba(148,163,184,.65);
            border-radius: 999px;
            border: 3px solid transparent;
            background-clip: content-box;
        }
        .scroll-nice::-webkit-scrollbar-thumb:hover{
            background: rgba(100,116,139,.85);
            border: 3px solid transparent;
            background-clip: content-box;
        }
        table.dataTable thead th {
            position: relative;
            cursor: pointer;
            user-select: none;
        }
        /* Netral sort */
        table.dataTable thead th.sorting::after {
            content: "⇅";
            font-size: 10px;
            color: #9ca3af; /* gray-400 */
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
        }

        /* asc */
        table.dataTable thead th.sorting_asc::after {
            content: "↑";
            color: #9ca3af; /* neutral-600 */
        }

        /* desc */
        table.dataTable thead th.sorting_desc::after {
            content: "↓";
            color: #9ca3af;
        }

        /* kolom non-orderable */
        table.dataTable thead th.sorting_disabled::after {
            display: none;
        }

        /* wrapper paginate */
        .dataTables_paginate{
            display:flex !important;
            justify-content:flex-end;
            gap:.5rem;
            align-items:center;
        }

        .dataTables_paginate span{
            display:flex;
            gap:.25rem;
            align-items:center;
        }

        /* tombol */
        .dataTables_paginate .paginate_button{
            display:inline-flex !important;
            align-items:center;
            justify-content:center;
            width:40px;
            height:40px;
            padding:0 !important;
            margin:0 !important;
            border-radius:.75rem;
            border:1px solid rgba(229,231,235,.8) !important;
            background:#fff !important;
            color:#111827 !important;
            line-height:1 !important;
            transition: background .15s ease, border-color .15s ease;
        }

        /* ikon prev/next */
        .dataTables_paginate .paginate_button i{
            font-size:14px;
            line-height:1;
        }

        /* active */
        .dataTables_paginate .paginate_button.current{
            background:#111827 !important;
            border-color:#111827 !important;
            color:#fff !important;
        }

        /* hover */
        .dataTables_paginate .paginate_button:not(.disabled):not(.current):hover{
            background:#f9fafb !important;
        }

        /* disabled */
        .dataTables_paginate .paginate_button.disabled{
            opacity:.5;
            cursor:not-allowed !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @php
            $openKey =
                request()->routeIs('users.*') ? 'users' :
                (request()->routeIs('templates.*') ? 'templates' :
                (request()->routeIs('invitations.*') ? 'invitations' : null));
        @endphp
        <aside class="flex flex-col w-64 bg-gradient-to-b from-neutral-900 to-neutral-700 text-white flex-shrink-0" x-data="{ open: @js($openKey) }">
            <div class="p-6 border-b border-neutral-700">
                <h1 class="text-2xl font-bold">Invitato</h1>
                <p class="text-xs text-neutral-300 mt-1">Admin Panel</p>
            </div>
            
            <nav class="p-4 space-y-2 overflow-y-auto flex-1 scroll-nice">
                <!-- Dashboard -->
                <a href="/dashboard" class="flex items-center px-4 py-3 rounded-lg hover:bg-neutral-700 transition {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-700' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <!-- User Management -->
                <div>
                    <button @click="open = open === 'users' ? null : 'users'" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition hover:bg-white/10" :class="open === 'users' ? 'bg-white/10' : ''">
                        <div class="flex items-center">
                            <i class="fas fa-users w-5"></i>
                            <span class="ml-3">Users</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform" :class="open === 'users' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open === 'users'" x-collapse class="ml-4 mt-2 space-y-1">
                        <a href="/users" class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition text-neutral-100/80 hover:text-white hover:bg-white/10 {{ request()->routeIs('users.index') ? 'bg-white/15 text-white' : '' }}">
                            <span class="h-2 w-2 rounded-full bg-white/30 group-hover:bg-white/70 {{ request()->routeIs('users.index') ? 'bg-white' : '' }}"></span>
                            <span>Daftar User</span>
                        </a>
                    </div>
                </div>

                <!-- Template Management -->
                <a href="/templates" class="flex items-center px-4 py-3 rounded-lg hover:bg-neutral-700 transition {{ request()->routeIs('templates.*') ? 'bg-white/15 text-white' : '' }}">
                    <i class="fas fa-palette w-5"></i>
                    <span class="ml-3">Templates</span>
                </a>

                <!-- Invitation Management -->
                <div>
                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-neutral-700 transition">
                        <div class="flex items-center">
                            <i class="fas fa-envelope-open-text w-5"></i>
                            <span class="ml-3">Undangan</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform" :class="open === 'invitations' ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open === 'invitations'" x-collapse class="ml-8 mt-2 space-y-1">
                        <a href="/invitations" class="flex items-center px-4 py-2 rounded-lg hover:bg-neutral-700 text-sm {{ request()->routeIs('admin.invitations.*') ? 'bg-neutral-700' : '' }}">
                            <i class="fas fa-list w-4 text-xs"></i>
                            <span class="ml-3">Daftar Undangan</span>
                        </a>
                        <a href="invitations/add" class="flex items-center px-4 py-2 rounded-lg hover:bg-neutral-700 text-sm">
                            <i class="fas fa-plus w-4 text-xs"></i>
                            <span class="ml-3">Buat Undangan</span>
                        </a>
                    </div>
                </div>

                <!-- Payment Management -->
                <a href="/payments" class="flex items-center px-4 py-3 rounded-lg hover:bg-neutral-700 transition {{ request()->routeIs('payments.*') ? 'bg-white/15 text-white' : '' }}">
                    <i class="fas fa-money-bill-wave w-5"></i>
                    <span class="ml-3">Payments</span>
                </a>

                <!-- Reports -->
                <a href="/reports" class="flex items-center px-4 py-3 rounded-lg hover:bg-neutral-700 transition {{ request()->routeIs('admin.reports.*') ? 'bg-neutral-700' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="ml-3">Laporan</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-neutral-700 bg-neutral-900">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-neutral-600 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold">Superadmin</p>
                            <p class="text-xs text-neutral-300">Admin</p>
                        </div>
                    </div>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="text-neutral-300 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200/70 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-gray-900">@yield('header')</h2>
                    <div class="flex items-center space-x-4">
                        <button class="relative text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 scroll-nice bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
    <div x-data="toastHub()" class="fixed top-4 right-4 z-[9999] w-[340px] max-w-[calc(100vw-2rem)] space-y-2 pointer-events-none">
        <template x-for="t in toasts" :key="t.id">
            <div
            x-show="t.show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            class="relative overflow-hidden rounded-2xl border bg-white shadow-lg pointer-events-auto"
            :class="t.type === 'success' ? 'border-emerald-200' : 'border-red-200'"
            >
            <div class="relative">
                <div class="flex items-start gap-3 pl-3 pr-2 py-2">
                    <div class="mt-0.5 h-8 w-8 rounded-xl flex items-center justify-center"
                        :class="t.type === 'success'
                            ? 'bg-emerald-50 text-emerald-600'
                            : 'bg-red-50 text-red-600'">
                        <i class="fas text-[13px]" :class="t.type === 'success' ? 'fa-check' : 'fa-times'"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 leading-tight"
                        x-text="t.type === 'success' ? 'Berhasil' : 'Gagal'"></p>
                        <p class="text-sm text-gray-600 break-words leading-snug mt-0.5"
                        x-text="t.message"></p>
                    </div>

                    <button
                        class="h-8 w-8 rounded-xl flex items-center justify-center
                            text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition"
                        @click="remove(t.id)"
                        aria-label="Close"
                    >
                        <i class="fas fa-xmark text-[14px]"></i>
                    </button>
                </div>
            </div>

            <div class="h-1.5 bg-gray-100">
                <div class="h-1.5"
                    :class="t.type === 'success' ? 'bg-emerald-500/60' : 'bg-red-500/60'"
                    :style="`width:${t.progress}%; transition: width 100ms linear;`"></div>
            </div>
            </div>
        </template>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('toastHub', () => ({
                toasts: [],

                init() {
                    window.addEventListener('toast:push', (e) => {
                        const { type = 'success', message = '', duration = 3200 } = e.detail || {};
                        this.push(type, message, duration);
                    });

                    const el = document.getElementById('toast-session');
                    if (el) {
                        const type = el.dataset.type;
                        const message = el.dataset.message;
                        if (type && message) {
                        this.push(type, message, 3200);
                        el.dataset.type = '';
                        el.dataset.message = '';
                        }
                    }
                },

                push(type, message, duration = 3200) {
                    const id = Date.now() + Math.random();

                    const toast = {
                        id,
                        type,
                        message,
                        show: true,
                        progress: 100,
                    };

                    this.toasts.unshift(toast);
                    if (this.toasts.length > 5) this.toasts.pop();

                    const start = Date.now();
                    const timer = setInterval(() => {
                        const elapsed = Date.now() - start;
                        const pct = Math.max(0, 100 - (elapsed / duration) * 100);
                        const t = this.toasts.find(x => x.id === id);
                        if (t) t.progress = pct;

                        if (elapsed >= duration) {
                            clearInterval(timer);
                            this.remove(id);
                        }
                    }, 100);
                },

                remove(id) {
                    const t = this.toasts.find(x => x.id === id);
                    if (!t) return;
                    t.show = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(x => x.id !== id);
                    }, 160);
                }
            }));
        });

        window.toast = function (type, message, opts = {}) {
            window.dispatchEvent(
                new CustomEvent('toast:push', {
                    detail: { type, message, ...opts }
                })
            );
        };
    </script>
    <div id="toast-session" data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : '') }}" data-message="{{ session('success') ?? session('error') ?? '' }}" class="hidden"></div>
    @stack('scripts')
</body>
</html>