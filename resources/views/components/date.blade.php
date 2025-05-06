@props([
    'date',
    'format' => 'd/m/Y',
    'class' => ''
])

<span class="{{ $class }}">
    {{ \Carbon\Carbon::parse($date)->format($format) }}
</span>
