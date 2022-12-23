@props([
'label' => null,
'placeholder' => null,
'options' => [],
'icon' => null,
'prepend' => null,
'append' => null,
'size' => null,
'col' => null,
'help' => null,
'model' => null,
'lazy' => false,
'search' => false,
'value' => null,
])

@php
if ($lazy) $bind = 'lazy';
else $bind = 'defer';

$wireModel = $attributes->whereStartsWith('wire:model')->first();
$key = $attributes->get('name', $model ?? $wireModel);
$id = $attributes->get('id', $key ?? $model ?? $wireModel);
$prefix = config('laravel-bootstrap-components.use_with_model_trait') ? 'model.' : null;
$options = collect($options);
$placeholder = $attributes->get('placeholder', $placeholder ?? '- Silahkan Pilih -');
$col = $attributes->get('col', $col);
$search = $attributes->get('search', $search);
$class = $search ? 'form-control search' : 'custom-select';

if(!empty($col)){
	$column = 'col-md-'.$col;
}
else{
	if($search){
		$column = 'col-md-4';
	}
	else{
		$column = 'col';
	}
}

$options = $options->prepend($placeholder, '');

$label = $attributes->get('label', $label ?? Str::title($key));

$attributes = $attributes->class([
$class,
'custom-select-' . $size => $size,
'is-invalid' => $errors->has($key),
])->merge([
'id' => $id,
'data-placeholder' => $placeholder,
'wire:model.' . $bind => $model ? $prefix . $model : null,
]);
@endphp


<div class="form-group {{ $column }} {{ $errors->has($key) ? 'has-error' : '' }}">
	<x-label :for="$id" :label="$label" />
	@if((!empty($prepend) or !empty($append)) && !$search)
	<div class="input-group">
	@endif

		@if(!empty($prepend))
		<div class="input-group-prepend">
			<label class="input-group-text" for="{{ $id }}">{{ __($prepend) }}</label>
		</div>
		@endif

		{!! Form::select($key, $options, request()->input($attributes['name'], old($attributes['name'])),
		collect($attributes)->toArray()) !!}

		@if(!empty($append))
		<div class="input-group-append">
			<label class="input-group-text" for="{{ $id }}">{{ __($append) }}</label>
		</div>
		@endif

	@if((!empty($prepend) or !empty($append)) && !$search)
	</div>
	@endif

	<x-error :key="$key" />
</div>
