@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'selected' => null,
    'submitOnChange' => false,
])

<form method="GET" action="{{ $action ?? request()->url() }}" class="mb-6 text-center">
    @if($label)
        <label for="{{ $name }}" class="font-semibold">
            {{ __($label) }}:
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($submitOnChange) onchange="this.form.submit()" @endif
        class="border rounded w-32 px-3 py-1"
    >
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ __($text) }}
            </option>
        @endforeach
    </select>
</form>
