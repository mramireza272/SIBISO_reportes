@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO | Acceso al sistema')

@section('titulo_pagina', 'Permiso')

@section('content')
<div class="panel">
   <div class="panel-body">
		<h2 class="panel-title"><strong>{{ $permission->name }}</strong><em>({{ isset($permission->description) ? $permission->description : 'Sin descripción' }})</em></h2>
    </div>
    <div class="panel-footer text-right">
    	<a role="button" href="{{ route('permisos.index') }}" class="btn btn-primary">Regresar</a>
	</div>
</div>
@endsection