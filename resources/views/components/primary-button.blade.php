<button {{ $attributes->merge(['type' => 'submit', 'class' => 'font-semibold bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition']) }}>
    {{ $slot }}
</button>