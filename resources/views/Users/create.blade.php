@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Nuevo Usuario')

@section('customcss')
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
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

	            <form method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data"
	                  class="panel-body form-horizontal form-padding">
	                  <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
	                  @php($default = true)
	                  @include('Users.form', ['user' => new App\User])
				</form>
			</div>
	    </div>
	</div>
@endsection

@section('customjs')
@endsection