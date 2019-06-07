@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Nuevo Reporte')

@section('customcss')
	<style>
        table {
          table-layout:fixed;
        }
        table td {
          word-wrap: break-word;
          max-width: 400px;
        }
        #example td {
          white-space:inherit;
        }
    </style>
<!--Bootstrap Validator [ OPTIONAL ]-->
    <link href="/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
        <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="/plugins/pace/pace.min.css" rel="stylesheet">
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
	           /* startDate:'2019/04/22',
	            endDate:'2019/12/31'*/
	    	});
	    });
	</script>
	<!--Bootstrap Validator [ OPTIONAL ]-->
	<script src="/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
	<script src="/plugins/pace/pace.min.js"></script>
@endsection

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
			<form method="POST" action="{{ route('forma.store') }}">
				<input type="hidden" name="active" value="1">
				<input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
				@include('forms.form', ['report' => new \App\Models\Report])
			</form>
		</div>
	</div>
@endsection