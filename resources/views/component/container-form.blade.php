<x-layout>

	<x-slot name="action">
		<input class="btn-check-m d-lg-none" type="checkbox">
		<a href="{{ moduleRoute('postDelete') }}" class="btn btn-danger button-delete-all">
			{{ __('Delete') }}
		</a>
		<a href="{{ moduleRoute('getCreate') }}" class="btn btn-success button-create">
			{{ __('Create') }}
		</a>
	</x-slot>

	<x-card>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
					<label>{{ __('Full Name') }}</label>
					{!! Form::text('name', null, ['class' => 'calendar form-control', 'id' => 'name', 'required']) !!}
					{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
					<label>{{ __('Username') }}</label>
					{!! Form::text('username', null, ['class' => 'datetime form-control', 'id' => 'username',
					'required']) !!}
					{!! $errors->first('username', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Vendor</label>
					{!! Form::select('vendor', $vendor, null, ['class' => 'form-control select2', 'id' =>
					'select-beast', 'placeholder' => '- Pilih vendor -', 'required']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
					<label>{{ __('Handphone') }}</label>
					{!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'required']) !!}
					{!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
					<label>Role</label>
					{!! Form::select('role', $roles, null, ['class' => 'form-control', 'id' =>
					'role', 'placeholder' => '- Pilih role -', 'required']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
					<label>Email address</label>
					{!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
					{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
					<label>Password</label>
					{!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
					{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

		</div>

	</x-card>

	<x-script-form />

</x-layout>