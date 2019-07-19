@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Nuevo Permiso')

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
    		<form method="POST" action="{{ route('permisos.store') }}">
    			@include('permissions.form')
    		</form>
        </div>
    </div>
@endsection