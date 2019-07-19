@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Editar Registro')

@section('customcss')
	<style>
    	textarea {
      		resize: none;
    	}
    </style>
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
	    	$('.fechapicker').datetimepicker({
	    		minView: 2,
	    		pickTime: false,
	    		language: 'es',
	    		format: 'yyyy-mm-dd',
	    		autoclose: true,
	        	todayBtn: true,
	        	pickerPosition: "bottom-left"
	    	});
	    });
	</script>
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	        <div class="panel">
	        	@if(session()->has('info'))
			    	<div class="panel">
			        	<div class="alert alert-success">{!! session('info') !!}
			        		<button class="close" data-dismiss="alert">
	                        	<i class="pci-cross pci-circle"></i>
	                    	</button>
			        	</div>
				    </div>
			    @endif
	        	<form method="POST" action="{{ route('registros.update', $report->id) }}" enctype="multipart/form-data" class="form-horizontal form-padding">
	                  {!! method_field('PUT') !!}
	                  <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
	                  <input type="hidden" name="report_id" value="{{ $report->id }}">
	                  @include('records.form', ['btnText' => 'Actualizar', 'action' => 'edit'])
				</form>
			</div>
	    </div>
	</div>
@endsection