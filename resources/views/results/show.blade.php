@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Ver Resultado Ampliado')

@section('customcss')
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
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	        <div class="panel">
	        	<form class="panel-body form-horizontal form-padding">
	        		<div class="panel-heading">
			            <h3 class="panel-title">Reporte: <strong>{{ $result->theme_result }}</strong></h3>
	                </div>
	                <div class="panel-heading">
			            <h3 class="panel-title">Área: <strong>{{ $result->rol->name }}</strong></h3>
	                </div>
					<div class="panel-body">
						<div class="form-group">
					        <label class="control-label col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left"><strong>Periodo al que corresponde la información: *</strong></label>
					        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left">
					            <input autocomplete="off" type='text' class="form-control date fechapicker" name="date_start" value="{{ old('date_start') }}" placeholder="Fecha de inicio del periodo" />
					            {!! $errors->first('date_start', '<small class="help-block text-danger">:message</small>') !!}
					        </div>
					        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left">
					            <input autocomplete="off" type='text' class="form-control date fechapicker" name="date_end" value="{{ old('date_end') }}" placeholder="Fecha del fin del periodo" />
					            {!! $errors->first('date_end', '<small class="help-block text-danger">:message</small>') !!}
					        </div>
					        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left">
					        	<button title="Eliminar" id="search" class="btn btn-sm btn-info">Buscar</button>
					        </div>
					    </div>
		            </div>
					<div class="panel-footer text-right">
						<a role="button" href="{{ route('resultados.index') }}" class="btn btn-primary">Regresar</a>
					</div>
				</form>
			</div>
	    </div>
	</div>
@endsection