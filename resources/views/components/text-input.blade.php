@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-blue-5 focus:ring-blue-5 rounded-md shadow-sm']) }}>
