<x-guest-layout>

<div class="min-h-screen flex">

    {{-- KIRI : ILUSTRASI --}}
    <div class="hidden lg:flex w-1/2
                bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950
                items-center justify-center">

        <lottie-player
    src="{{ asset('lottie/teamwork-login.json') }}"
    background="transparent"
    speed="1"
    loop
    autoplay
    class="w-[90%] max-w-2xl">
</lottie-player>
    </div>



    {{-- KANAN : FORM LOGIN --}}
   <div class="w-full lg:w-1/2 flex items-center justify-center
            bg-gradient-to-br from-slate-200 via-slate-300 to-slate-200">

        <div class="w-full max-w-md bg-white p-8 rounded-3xl
                    shadow-[0_10px_40px_rgba(0,0,0,0.15)]">

            {{-- LOGO --}}
            <div class="text-center mb-6">
                <img src="{{ asset('img/logo-arjuna.png') }}"
                     class="w-16 mx-auto mb-2">

                <h1 class="font-bold text-slate-800 tracking-wide">
                    ARJUNA
                </h1>

                <p class="text-xs text-gray-500">
                    Registrasi Naskah & Arsip Digital
                </p>
            </div>


            {{-- VALIDATION ERROR --}}
            <x-validation-errors class="mb-4" />


            {{-- LOGIN GOOGLE --}}
            <a href="{{ url('auth/google') }}"
               class="flex items-center justify-center gap-3 border rounded-lg py-2 mb-4
                      hover:bg-gray-50 transition">

                <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                     class="w-5">

                <span class="text-sm font-medium text-gray-700">
                    Login dengan Google
                </span>
            </a>


            <div class="flex items-center my-4">
                <div class="flex-1 border-t"></div>
                <span class="px-3 text-sm text-gray-400">atau</span>
                <div class="flex-1 border-t"></div>
            </div>


            {{-- FORM LOGIN --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" required
                           class="w-full mt-1 rounded-lg border-gray-300
                                  focus:ring-slate-800 focus:border-slate-800">
                </div>

                <div class="mb-2">
                    <label class="text-sm text-gray-600">Password</label>
                    <div class="mb-2">
    
    <input type="password" name="password" id="login_password"
           class="w-full mt-1 rounded-lg border border-slate-300
                  bg-slate-100 focus:bg-white
                  focus:ring-slate-700 focus:border-slate-700">

    <label class="flex items-center gap-2 mt-2 text-sm text-slate-600">
        <input type="checkbox" onclick="togglePassword('login_password')">
        Lihat password
    </label>
</div>

                <div class="flex justify-between items-center mb-6 text-sm">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="{{ route('password.request') }}"
                       class="text-slate-700 hover:underline">
                        Lupa password?
                    </a>
                </div>

                <button class="w-full
                               bg-gradient-to-r from-slate-800 to-indigo-700
                               hover:scale-[1.02]
                               text-white py-2 rounded-lg font-semibold transition">
                    Masuk
                </button>

            </form>


            {{-- MENU DAFTAR --}}
            <div class="text-center mt-6 text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="text-indigo-700 font-semibold hover:underline">
                    Daftar
                </a>
            </div>

        </div>

    </div>

</div>

</x-guest-layout>