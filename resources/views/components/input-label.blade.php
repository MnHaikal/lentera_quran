@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-body-sm text-ink']) }}>
    {{ $value ?? $slot }}
</label>
