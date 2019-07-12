@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO | Acceso al sistema')

@section('titulo_pagina', 'Nuevo Rol')

@section('content')
<div class="panel">
	@if(session()->has('info'))
    	<div class="panel-heading">
        	<div class="alert alert-success">{{ session('info') }}
        		<button class="close" data-dismiss="alert">
                	<i class="pci-cross pci-circle"></i>
            	</button>
        	</div>
	    </div>
    @endif
    <div class="panel-body">
		<form method="POST" action="{{ route('roles.store') }}">
			@include('roles.form', ['role' => new Spatie\Permission\Models\Role ])
		</form>
    </div>
</div>
@endsection