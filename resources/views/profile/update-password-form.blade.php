<form wire:submit.prevent="updateProfileInformation" class="space-y-6">

    {{-- FOTO --}}
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div class="flex items-center gap-4">

            <img src="{{ $this->user->profile_photo_url }}"
                 class="w-16 h-16 rounded-full object-cover">

            <div class="flex gap-2">
                <input type="file" class="hidden" wire:model.live="photo" x-ref="photo">

                <x-secondary-button type="button"
                    x-on:click.prevent="$refs.photo.click()">
                    Ganti Foto
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" wire:click="deleteProfilePhoto">
                        Hapus
                    </x-secondary-button>
                @endif
            </div>
        </div>
    @endif


    {{-- NAMA --}}
    <div>
        <x-label value="Name"/>
        <x-input type="text" class="w-full mt-1"
                 wire:model.defer="state.name"/>
        <x-input-error for="name"/>
    </div>


    {{-- EMAIL --}}
    <div>
        <x-label value="Email"/>
        <x-input type="email" class="w-full mt-1"
                 wire:model.defer="state.email"/>
        <x-input-error for="email"/>
    </div>


    {{-- BUTTON --}}
    <div class="flex justify-end">
        <x-button>Simpan</x-button>
    </div>

</form>