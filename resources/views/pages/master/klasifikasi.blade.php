<x-app-layout>


<div class="mb-4">
    <input type="text"
           id="searchKlasifikasi"
           placeholder="Cari kode / nama klasifikasi..."
           class="w-full border rounded-lg px-4 py-2">
</div>

<h2 class="text-lg font-semibold mb-4">Bagan Klasifikasi</h2>

<ul class="space-y-1">

    @foreach($data as $item)
        @include('pages.master.partials.klasifikasi-item', ['item' => $item])
    @endforeach

</ul>

<script>

document.addEventListener("DOMContentLoaded", function () {

    // ===============================
    // TOGGLE TREE
    // ===============================
    document.querySelectorAll('.toggle').forEach(function(el){

    el.addEventListener('click', function(){

        let sub = this.parentElement.querySelector("ul");

        if(sub){

            sub.classList.toggle("hidden");

            let arrow = this.querySelector(".arrow");

            if(arrow){
                arrow.classList.toggle("rotate-90");
            }

        }

    });

});


    // ===============================
    // SEARCH
    // ===============================
    document.getElementById('searchKlasifikasi')
    .addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();

        document.querySelectorAll('.klas-item').forEach(li => {

            let text = li.innerText.toLowerCase();

            li.style.display = text.includes(keyword) ? "block" : "none";

        });

    });

});

</script>

</x-app-layout>
