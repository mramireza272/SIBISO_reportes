@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Editar Rol')

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
    		<form method="POST" action="{{ route('roles.update', $role->id) }}">
    			{!! method_field('PUT') !!}
    			@include('roles.form', ['btnText'=> 'Actualizar'])
    		</form>
        </div>
    </div>
@endsection