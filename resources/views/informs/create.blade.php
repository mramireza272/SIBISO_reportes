@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Nuevo Reporte')

@section('customcss')
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
	    	$("#rol_id").chosen({no_results_text: "Sin resultados encontrados", width: "100%"});
	    });
	</script>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="panel">
				@if(session()->has('info'))
			    	<div class="panel">
			        	<div class="alert alert-success">{{ session('info') }}
			        		<button class="close" data-dismiss="alert">
		                    	<i class="pci-cross pci-circle"></i>
		                	</button>
			        	</div>
				    </div>
			    @endif
				<form method="POST" action="{{ route('informes.store') }}" class="panel-body form-horizontal form-padding">
					@include('informs.form', ['result' => new \App\Models\Result, 'action' => 'create'])
				</form>
			</div>
		</div>
	</div>
@endsection