@props([
'label' => null,
'model' => null,
])

@php
$attributes = $attributes->class([
'form-label',
])->merge([
//
]);
@endphp

@section('title')
<h4>{{ moduleName($label) }}</h4>
@endsection

@section('container')

{!! Template::form_open($model) !!}

@if(!request()->ajax())
<div class="page-header">
	<div class="header-container container-fluid d-sm-flex justify-content-between">
		@yield('title')
		@yield('action')
	</div>
</div>
@endif

<div class="card">
	<div class="card-body">

        {{ $slot }}

	</div>
</div>

{!! Template::form_close() !!}

@endsection