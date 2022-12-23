@props([
    'name' => null,
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
