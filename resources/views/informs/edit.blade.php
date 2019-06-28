@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Editar Informe')

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
	    	@if(session()->has('info'))
		    	<div class="panel">
		        	<div class="alert alert-success">{{ session('info') }}
		        		<button class="close" data-dismiss="alert">
                        	<i class="pci-cross pci-circle"></i>
                    	</button>
		        	</div>
			    </div>
		    @endif
	        <div class="panel">
	        	<form method="POST" action="{{ route('informes.update', $result->id) }}" enctype="multipart/form-data" class="panel-body form-horizontal form-padding">
	                  {!! method_field('PUT') !!}
	                  @include('informs.form', ['btnText' => 'Actualizar', 'action' => 'edit'])
				</form>
			</div>
	    </div>
	</div>
@endsection