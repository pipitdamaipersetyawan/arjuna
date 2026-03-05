<x-app-layout>

<div class="max-w-4xl mx-auto space-y-6"
     x-data="{ edit: window.location.hash !== '#password' }"
     x-on:hashchange.window="edit = (window.location.hash !== '#password')">

    {{-- ================= DATA PROFIL ================= --}}
    <div class="bg-white p-6 rounded-2xl shadow">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Informasi Profil</h2>

            <button
                x-show="!edit"
                @click="edit=true"
                class="text-sm bg-slate-900 text-white px-4 py-2 rounded-lg">
                Edit
            </button>
        </div>

        {{-- ✅ SUCCESS MESSAGE --}}
        <div
            x-data="{ show:false }"
            x-on:profile-saved.window="show=true; setTimeout(() => show=false, 3000)"
            x-show="show"
            x-transition
            class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
            Profil berhasil diperbarui
        </div>

        {{-- TAMPIL SAAT MODE VIEW --}}
        <div x-show="!edit" class="space-y-3 text-sm">

            <div>
                <div class="text-slate-500">Nama</div>
                <div class="font-semibold">{{ Auth::user()->name }}</div>
            </div>

            <div>
                <div class="text-slate-500">Email</div>
                <div class="font-semibold">{{ Auth::user()->email }}</div>
            </div>

        </div>

        {{-- TAMPIL SAAT MODE EDIT --}}
        <div x-show="edit" x-transition>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')

    <div class="space-y-4">

        <div>
            <x-label value="Nama" />
            <x-input type="text" class="w-full"
                     name="name"
                     value="{{ auth()->user()->name }}" />
        </div>

        <div>
            <x-label value="Email" />
            <x-input type="email" class="w-full"
                     name="email"
                     value="{{ auth()->user()->email }}" />
        </div>

    </div>

    <div class="flex justify-end gap-2 mt-6">

        <button type="button"
                @click="edit=false"
                class="px-4 py-2 text-sm bg-slate-200 rounded-lg">
            Batal
        </button>

        <x-button>Simpan</x-button>

    </div>

</form>

</div>

    </div>



    {{-- ================= PASSWORD ================= --}}
   <div id="password"
     class="bg-white p-6 rounded-2xl shadow"
     x-data="{ open: window.location.hash === '#password' }"
     x-show="open"
     x-transition
     x-on:hashchange.window="open = (window.location.hash === '#password')">

      <div class="bg-white p-6 rounded-2xl shadow">

    <h2 class="text-lg font-bold mb-4">Ganti Password</h2>

    <form method="POST" action="{{ route('user-password.update') }}">
        @csrf
        @method('PUT')

        {{-- CURRENT PASSWORD --}}
        <div class="mb-4">
            <x-label value="Current Password" />
            <x-input type="password" name="current_password" id="current_password" class="w-full" />
<x-input-error for="current_password" class="mt-2" />
            <label class="text-sm flex items-center gap-2 mt-1">
                <input type="checkbox" onclick="togglePassword('current_password')">
                Lihat Password
            </label>
        </div>

        {{-- NEW PASSWORD --}}
        <div class="mb-4">
            <x-label value="New Password" />
            <x-input type="password" name="password" id="new_password" class="w-full" />
<x-input-error for="password" class="mt-2" />
            <label class="text-sm flex items-center gap-2 mt-1">
                <input type="checkbox" onclick="togglePassword('new_password')">
                Lihat Password
            </label>
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="mb-4">
            <x-label value="Confirm Password" />
            <x-input type="password" name="password_confirmation" id="password_confirmation" class="w-full" />
<x-input-error for="password_confirmation" class="mt-2" />
            <label class="text-sm flex items-center gap-2 mt-1">
                <input type="checkbox" onclick="togglePassword('password_confirmation')">
                Lihat Password
            </label>
        </div>

        <div class="flex justify-end">
            <x-button>Simpan</x-button>
        </div>

    </form>

</div>

    </div>

</div>



{{-- AUTO CLOSE EDIT SETELAH SAVE --}}
<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('profile-updated', () => {
        window.dispatchEvent(new Event('profile-saved'))
    })
})
</script>

{{-- AUTO SCROLL KE PASSWORD --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    if (window.location.hash === "#password") {

        const el = document.getElementById("password");

        if (el) {
            el.scrollIntoView({ behavior: "smooth" });
        }

    }

});
</script>
<script>
function togglePassword(id) {
    let input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
</script>
</x-app-layout>