@props([
    'name' => 'terms',
    'required' => true,
    'text' => 'I accept the terms and conditions',
    'description' => null,
])

<div class="mb-4 mt-1">
    @if($description)
        <p class="text-sm text-gray-700 mb-2">
            {{ $description }}
        </p>
    @endif

    <label class="flex items-center">
        <input type="checkbox" name="{{ $name }}" {{ $required ? 'required' : '' }} class="mr-2">
        {{ $text }}
    </label>
</div>
