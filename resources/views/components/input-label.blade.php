@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-1']) }}>
    {{ $value ?? $slot }}
</label>
