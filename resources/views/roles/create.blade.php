@extends('templates.master')

@section('titulo')
	Sistema de Reportes SIBISO | Acceso al sistema
@endsection

@section('titulo_pagina')
	Nuevo Rol
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
		<form method="POST" action="{{ route('roles.store') }}">
			@include('roles.form', ['role' => new Spatie\Permission\Models\Role ])	
		</form>
    </div>
</div>
@endsection