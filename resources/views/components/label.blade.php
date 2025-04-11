@props(['for'])

<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-gray-700 font-medium']) }}>
    {{ $slot }}
</label>
