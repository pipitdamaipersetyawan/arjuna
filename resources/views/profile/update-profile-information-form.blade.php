<form method="POST" action="{{ route('user-profile-information.update') }}">
    @csrf
    @method('PUT')

    <div>
        <label>Nama</label>
        <input type="text"
               name="name"
               value="{{ old('name', auth()->user()->name) }}"
               class="w-full border rounded px-3 py-2">
    </div>

    <div class="mt-3">
        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', auth()->user()->email) }}"
               class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit">SIMPAN</button>
</form>