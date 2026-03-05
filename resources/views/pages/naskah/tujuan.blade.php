@props(['listTujuan', 'selected' => [], 'manual' => null])

<div class="col-span-2">

<label class="block text-sm font-medium text-slate-600 mb-1">
Tujuan *
</label>

<select name="tujuan[]" multiple
        class="w-full border rounded-lg text-sm">

@foreach($listTujuan as $group => $items)
    <optgroup label="{{ $group }}">
        @foreach($items as $t)
            <option value="{{ $t->id }}"
                {{ in_array($t->id, $selected) ? 'selected' : '' }}>
                {{ $t->nama }}
            </option>
        @endforeach
    </optgroup>
@endforeach

</select>

{{-- manual lama --}}
@if($manual)
    @foreach(explode(',', $manual) as $m)
        <input type="text"
               name="tujuan[]"
               value="{{ trim($m) }}"
               class="w-full border rounded-lg px-3 py-2 text-sm mt-2">
    @endforeach
@endif

{{-- input manual baru --}}
<input type="text"
       name="tujuan[]"
       placeholder="Tambah tujuan manual lalu tekan Enter"
       class="w-full border rounded-lg px-3 py-2 text-sm mt-2">

</div>
