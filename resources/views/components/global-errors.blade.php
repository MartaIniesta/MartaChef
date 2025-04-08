@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4 text-red-500']) }}>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
