<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-1 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-0 focus:bg-blue-0 active:bg-blue-0 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
