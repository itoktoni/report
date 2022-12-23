@props([
    'button' => null,
    'route' => null,
])

@php
    $attributes = $attributes->class([
        'form-label',
    ])->merge([
        //
    ]);
@endphp

@section('title')
<h4>{{ moduleName($name) }}</h4>
@endsection
