@props([
    'label' => null,
    'model' => null,
    'form' => false
])

@php
    $attributes = $attributes->class([
        'button',
    ])->merge([
        //
    ]);
@endphp

@section('action')
<div {{ $attributes }}>
{{ $slot }}
</div>
@endsection