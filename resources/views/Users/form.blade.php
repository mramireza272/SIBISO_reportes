{{--<div class="panel-body">--}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<fieldset>
	<!-- Name input-->
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="name"><strong>Nombre Completo *</strong></label>
			<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
				<input class="form-control" type="text" name="name" value="{{ $user->name ?? old('name') }}" placeholder="Nombre" required autofocus>
				{!! $errors->first('name', '<small class="help-block text-danger">:message</small>') !!}
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
				<input class="form-control" type="text" name="paterno" value="{{ $user->paterno ?? old('paterno') }}" placeholder="Apellido Paterno">
				{!! $errors->first('paterno', '<small class="help-block text-danger">:message</small>') !!}
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
				<input class="form-control" type="text" name="materno" value="{{ $user->materno ?? old('materno') }}" placeholder="Apellido Materno">
				{!! $errors->first('materno', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		{{-- <div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="hpone"><strong>Número Telefonico*</strong></label>
			<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
				<input class="form-control" type="text" name="phone" value="{{ $user->phone ?? old('phone')}}" placeholder="Telefono">
				{!! $errors->first('phone', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="name"><strong>IMEI*</strong></label>
			<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
				<input class="form-control" type="text" name="imei" value="{{ $user->imei ?? old('imei')}}" placeholder="IMEI">
				{!! $errors->first('imei', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div> --}}
	<!-- email input-->
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="email"><strong>Correo Personal *</strong></label>
			<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
				<input class="form-control" type="email" name="email" value="{{ $user->email ?? old('email')}}" placeholder="Correo Electrónico Personal" required>
				{!! $errors->first('email', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="email_confirmation"><strong>Confirmar Correo Personal *</strong></label>
			<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
				<input class="form-control" type="email" name="email_confirmation" value="{{ $user->email ?? old('email_confirmation') }}" placeholder="Confirmar Correo Electrónico Personal" required>
				{!! $errors->first('email_confirmation', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
	<!-- password input-->

	@if(auth()->user()->hasRole(['Administrador','Admin Proveedor']) || auth()->user()->id == $user->id || Session::has('Current.user.new'))
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="password"><strong>Contraseña *</strong></label>
			<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
				<input class="form-control" type="password" name="password" placeholder="**********" required>
				{!! $errors->first('password', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="password_confirmation"><strong>Confirmación de Contraseña *</strong></label>
			<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
				<input class="form-control" type="password" name="password_confirmation" placeholder="**********" required>
				{!! $errors->first('password_confirmation', '<small class="help-block text-danger">:message</small>') !!}
			</div>
		</div>
	@endif
	<input type="hidden" name="auth" value="{{ auth()->user()->id }}">
	<input type="hidden" name="user_id" value="{{ $user->id }}">

	<!-- role input-->
		<div class="form-group">
			<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 control-label" for="roles"><strong>Rol Asignado *</strong></label>
			<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
				@if(old('roles') !== null)
	                @php ($rol_id = collect(old('roles')))
	            @else
	                @php ($rol_id = collect())
	            @endif
				@foreach($roles as $id => $name)
					@php($check = str_random(5))
					<div class="checkbox">
						<input id="{{ $check }}" class="magic-radio" type="radio" name="roles[]" value="{{ $id }}"
							@if(isset($default))
								{{ ($rol_id->contains($id)) ? 'checked' : '' }}
							@else
								{{ $user->roles->pluck('name')->contains($id) ? 'checked' : ''}}
							@endif
						>
				        <label for="{{ $check }}">{{ $name }}</label>
					</div>
				@endforeach
				{!! $errors->first('roles', '<small class="help-block text-danger">:message</small>') !!}
				<hr>
			</div>
		</div>

	<!-- Form actions -->
		<div class="panel-footer text-right">
			<a role="button" href="{{ route('usuarios.index') }}" class="btn btn-primary">Regresar</a>
			<button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar' }}</button>
		</div>
	</fieldset>
{{--</div>--}}
