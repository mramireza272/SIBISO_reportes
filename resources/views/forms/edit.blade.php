@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Editar Reporte')

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
	        	<form method="POST" action="{{ route('forma.update', $report->id) }}" enctype="multipart/form-data" class="panel-body form-horizontal form-padding">
	                  {!! method_field('PUT') !!}
	                  <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
	                  @include('forms.form', ['btnText' => 'Actualizar'])
				</form>
			</div>
	    </div>
	</div>

@endsection