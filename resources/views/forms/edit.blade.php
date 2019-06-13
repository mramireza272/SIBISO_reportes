@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Editar Reporte')

@section('customcss')
        <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="/plugins/pace/pace.min.css" rel="stylesheet">
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
	    });
	</script>
	<script src="/plugins/pace/pace.min.js"></script>
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	    	@if(session()->has('info'))
		    	<div class="panel">
		        	<div class="alert alert-success">{!! session('info') !!}
		        		<button class="close" data-dismiss="alert">
                        	<i class="pci-cross pci-circle"></i>
                    	</button>
		        	</div>
			    </div>
		    @endif
	        <div class="panel">
	        	<form method="POST" action="{{ route('formularios.update', $rol->id) }}" enctype="multipart/form-data" class="form-horizontal form-padding">
	                  {!! method_field('PUT') !!}
	                  <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
	                  @include('forms.form', ['btnText' => 'Actualizar', 'action' => 'edit'])
				</form>
			</div>
	    </div>
	</div>
@endsection