@props([
'col' => null,
])

@php

$col = $attributes->get('col', $col ? 'col-md-'.$col : '');

$attributes = $attributes->class([
'row',
])->merge([
//
]);
@endphp

<div {{ $attributes }}>
	@if($col)
	<div class="{{ $col }}">
	@endif
		{{ $slot }}
	@if($col)
	</div>
	@endif
</div>