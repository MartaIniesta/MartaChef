@props([
    'name',
    'id' => $name,
    'type' => 'text',
    'value' => old($name),
    'required' => false,
    'placeholder' => '',
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ $value }}"
    placeholder="{{ __($placeholder) }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500'
    ]) }}
/>
