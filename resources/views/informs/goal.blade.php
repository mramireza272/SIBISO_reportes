@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Nueva Meta')

@section('customcss')
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
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
				<form method="POST" action="{{ route('informes.storegoal') }}" class="panel-body form-horizontal form-padding">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="result_id" value="{{ $result->id }}">
					<div class="panel-heading">
	                    <h3 class="panel-title"><strong>{{ $result->rol->name }}</strong></h3>
	                </div>
					<div class="form-group">
					    <label class="col-md-3 control-label" for="goal_txt"><strong>Nombre*</strong></label>
					    <div class="col-md-9">
					        <input type="text" id="goal_txt" name="goal_txt" class="form-control" placeholder="Ingrese el nombre de la meta" value="{{ old('goal_txt') }}" />
					        {!! $errors->first('goal_txt', '<small class="help-block text-danger">:message</small>') !!}
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-md-3 control-label" for="goal_unit"><strong>Unidad*</strong></label>
					    <div class="col-md-9">
					        <input type="text" id="goal_unit" name="goal_unit" class="form-control" placeholder="Ingrese la unidad" value="{{ old('goal_unit') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
					        {!! $errors->first('goal_unit', '<small class="help-block text-danger">:message</small>') !!}
					    </div>
					</div>
					<div class="panel-footer text-right">
						<a role="button" href="{{ route('informes.index') }}" class="btn btn-primary">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection