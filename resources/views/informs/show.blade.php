@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Ver Informe')

@section('customcss')
@endsection

@section('customjs')
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	        <div class="panel">
	        	<form class="panel-body form-horizontal form-padding">
	        		<div class="panel-heading">
	                    <h3 class="panel-title"><strong>{{ $result->rol->name .' - '. $result->theme_result}}</strong></h3>
	                </div>
					<div class="panel-body">
		                <div class="panel-heading">
		                    <h3 class="panel-title"><strong>Metas</strong></h3>
		                </div>
		                <div class="form-group">
						    <ul>
								@foreach($result->goals as $goal)
									<li><strong>{{ $goal->goal_txt }}</strong> <em>({{ $goal->goal_unit }})</em></li>
								@endforeach
							</ul>
						</div>
		            </div>
					<div class="panel-footer text-right">
						<a role="button" href="{{ route('informes.index') }}" class="btn btn-primary">Regresar</a>
					</div>
				</form>
			</div>
	    </div>
	</div>
@endsection