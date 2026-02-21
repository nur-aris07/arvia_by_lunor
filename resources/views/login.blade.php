<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Invitato Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .captcha-wrap img{
            height: 44px;
            width: auto;
            display: block;
        }
        .glass {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(10px);
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #111827;
            -webkit-box-shadow: 0 0 0px 1000px #ffffff inset;
            transition: background-color 9999s ease-in-out 0s;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-neutral-950 text-white">
    <!-- background accent -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-neutral-600/20 blur-3xl"></div>
        <div class="absolute top-1/3 -right-24 h-80 w-80 rounded-full bg-purple-600/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-neutral-500/10 blur-3xl"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-neutral-950 to-neutral-800"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            <!-- Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl glass shadow-lg mb-4">
                    <i class="fas fa-envelope-open-text text-2xl text-white/90"></i>
                </div>
                <h1 class="text-3xl font-semibold tracking-tight">Arvia by Lunor</h1>
                <p class="text-sm text-white/60 mt-1">Admin Panel</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200/70 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200/70">
                    <h2 class="text-lg font-semibold text-gray-900">Selamat Datang</h2>
                    <p class="text-sm text-gray-500">Silakan login untuk melanjutkan</p>
                </div>

                <div class="px-6 pb-6">
                    @if(session('error'))
                        <div class="my-3 rounded-xl border border-red-200/70 bg-red-50 px-4 py-3">
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-red-800">Gagal</p>
                                    <p class="text-sm text-red-700 break-words">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-5 rounded-xl border border-emerald-200/70 bg-emerald-50 px-4 py-3">
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-emerald-800">Berhasil</p>
                                    <p class="text-sm text-emerald-700 break-words">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="/login/auth" method="POST" class="space-y-4">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="admin@invitato.com"
                                    required
                                    autofocus
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none @error('email') border-red-300 @enderror"
                                >
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="••••••••"
                                    required
                                    class="w-full pl-10 pr-11 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none @error('password') border-red-300 @enderror"
                                >
                                <button
                                    type="button"
                                    id="togglePasswordBtn"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 h-9 w-9 rounded-xl
                                           inline-flex items-center justify-center text-gray-400
                                           hover:bg-gray-50 hover:text-gray-700 transition"
                                    aria-label="Toggle password"
                                >
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Captcha</label>
                            <div class="flex items-center gap-3">
                                <div class="captcha-wrap flex-1 h-[44px] rounded-xl border border-gray-200 bg-white flex items-center justify-center overflow-hidden">{!! captcha_img('math') !!}</div>
                                <button
                                    type="button"
                                    id="refreshCaptchaBtn"
                                    class="h-[44px] w-[44px] rounded-xl border border-gray-200 bg-white inline-flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition"
                                    title="Refresh captcha"
                                    aria-label="Refresh captcha"
                                >
                                    <i class="fas fa-rotate"></i>
                                </button>
                            </div>
                            <div class="mt-3">
                                <input
                                    type="text"
                                    name="captcha"
                                    placeholder="Jawaban captcha"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white
                                        text-gray-900 placeholder:text-gray-400
                                        focus:ring-4 focus:ring-neutral-200 focus:border-gray-300 outline-none
                                        @error('captcha') border-red-300 @enderror"
                                >
                                @error('captcha')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full py-2.5 rounded-xl bg-neutral-900 text-white hover:bg-neutral-800 transition
                                   inline-flex items-center justify-center gap-2 shadow-sm"
                        >
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="font-semibold">Login</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-white/60 text-sm">&copy; {{ date('Y') }} Invitato. All rights reserved.</p>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('togglePasswordBtn');
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (!btn || !input || !icon) return;

            btn.addEventListener('click', () => {
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPass);
                icon.classList.toggle('fa-eye-slash', isPass);
            });

            const refreshCaptchaBtn = document.getElementById('refreshCaptchaBtn');
            const captchaWrap = document.querySelector('.captcha-wrap');
            if (refreshCaptchaBtn && captchaWrap) {
                refreshCaptchaBtn.addEventListener('click', async () => {
                    try {
                        const res = await fetch("{{ route('captcha.refresh') }}", {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const json = await res.json();
                        captchaWrap.innerHTML = json.captcha;
                    } catch (e) {
                        console.log(e);
                        // window.location.reload();
                    }
                });
            }
        });
    </script>
</body>
</html>