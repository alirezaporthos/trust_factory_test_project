@props([
    'placeholder' => null,
])

<div class="flex">
  <select {{ $attributes->merge(['class' => 'block w-full shadow-sm pl-3 pr-10 py-3 text-base leading-6 border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5']) }}>
    @if ($placeholder)
        <option disabled value="">{{ $placeholder }}</option>
    @endif

    {{ $slot }}
  </select>

</div>
