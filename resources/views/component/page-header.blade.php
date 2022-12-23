@props([
    'label' => null,
])

@php
    $attributes = $attributes->class([
        '',
    ])->merge([
        //
    ]);
@endphp

<div class="page-header">
	<div class="header-container container-fluid d-sm-flex justify-content-between">
        <h4>{{ moduleName($label) }}</h4>
        {{ $slot }}
	</div>
</div>