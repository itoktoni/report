@props([
'label' => null,
'type' => null,
'placeholder' => null,
'required' => false,
'icon' => null,
'prepend' => null,
'append' => null,
'validation' => null,
'value' => null,
'button' => null,
'size' => null,
'help' => null,
'col' => null,
'model' => null,
'debounce' => false,
'lazy' => false,
])

@php

if ($debounce) $bind = 'debounce.' . (ctype_digit($debounce) ? $debounce : 150) . 'ms';
else if ($lazy) $bind = 'lazy';
else $bind = 'defer';

$validation = $attributes->get('validation', $validation ?? null);
$wireModel = $attributes->whereStartsWith('wire:model')->first();
$key = $attributes->get('name', $model ?? $wireModel);
$id = $attributes->get('id', $key ?? $model ?? $wireModel);
$prefix = config('laravel-bootstrap-components.use_with_model_trait') ? 'model.' : null;
$placeholder = $attributes->get('placeholder', $required ? '* Wajib diisi' : $placeholder);
$required = $attributes->get('required', $required);
$type = $attributes->get('type', $type ?? 'text');
$col = $attributes->get('col', $col ? 'col-md-'.$col : 'col');
$label = $attributes->get('label', $label ?? Str::title($key));
$value =

$attributes = $attributes->class([
'form-control',
'form-control-' . $size => $size,
'is-invalid' => $errors->has($key),
])->merge([
'type' => $type,
'name' => $key,
'placeholder' => $placeholder,
'id' => $id,
'wire:model.' . $bind => $model ? $prefix . $model : null,
]);
@endphp

<div class="form-group {{ $col }} {{ $errors->has($key) ? 'has-error' : '' }}">
	<x-label :for="$id" :label="$label" />

	@if(!empty($prepend) or !empty($append) or !empty($button) or !empty($icon))
	<div class="input-group">
		@if(!empty($prepend))
		<div class="input-group-prepend">
			<label class="input-group-text" for="{{ $id }}">{{ __($prepend) }}</label>
		</div>
		@endif
		@endif

		@if($type == 'password')
			{!! Form::password($key, collect($attributes)->toArray()) !!}
		@else
			<input type="text" {{ $attributes }}>
			{!! Form::text($key, $value, collect($attributes)->toArray()) !!}
		@endif

		@if(!empty($append))
		<div class="input-group-append">
			<label class="input-group-text" for="{{ $id }}">{{ __($append) }}</label>
		</div>
		@endif

		@if(!empty($button))
		<div class="input-group-append">
			<button class="btn btn-primary" type="submit">{{ __($button) }}</button>
		</div>
		@endif

		@if(!empty($icon))
		<div class="input-group-append">
			<button class="btn btn-primary" type="submit">
				<i class="bi bi-{{ $icon }}"></i>
			</button>
		</div>
		@endif

		@if(!empty($prepend) or !empty($append) or !empty($button) or !empty($icon))
	</div>
	@endif

	<x-error :key="$key" />
</div>