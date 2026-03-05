@if ($errors->any())
    <div {{ $attributes->merge([
        'class' => '
        mb-5
        rounded-2xl
        bg-rose-100
        border border-rose-200
        text-rose-700
        px-5 py-4
        text-sm font-semibold
        text-center
        shadow-sm
        ring-1 ring-rose-200
        animate-[fadeIn_.35s_ease-in-out]
        '
    ]) }}>

        {{ $errors->first() }}

    </div>
@endif
