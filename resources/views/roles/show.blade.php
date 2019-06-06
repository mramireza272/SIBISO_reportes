@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO | Acceso al sistema')

@section('titulo_pagina', 'Rol')

@section('content')
<div class="panel">
    <div class="panel-body">
		<h2 class="panel-title"><strong>{{ $role->name }}</strong></h2>
		<p><strong>Permisos</strong>
			<ul>
				@foreach($role->permissions as $permission)
					<li><strong>{{ $permission->name }}</strong> <em>{{ $permission->description }}</em></li>
				@endforeach
			</ul>
		</p>
    </div>
    <div class="panel-footer text-right">
    	<a role="button" href="{{ route('roles.index') }}" class="btn btn-primary">Regresar</a>
	</div>
</div>
@endsection