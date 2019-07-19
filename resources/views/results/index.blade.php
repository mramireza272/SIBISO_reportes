@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Resultados')

@section('customcss')
	<style>
	    table thead, th, tbody, td {
	    	text-align: center;
	    }
    </style>
@endsection

@section('customjs')
	<script type="application/javascript" >
		$(document).ready(function() {
		    $('select').chosen({no_results_text: "Sin resultados encontrados", width: "100%", allow_single_deselect:true});
		});
	</script>
@endsection

@section('content')
	@can('search_results')
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="panel">
					<form method="POST" action="{{ route('resultados.search') }}" class="panel-body form-horizontal form-padding">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-heading">
					        <h3 class="panel-title"><strong>Filtro</strong></h3>
					    </div>
					    <div class="form-group">
					    	<label class="control-label col-sm-3 col-md-3 col-lg-3 col-xl-3 text-right"><strong>Unidad Administrativa Responsable: </strong></label>
						    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						        <select data-placeholder="Selecciona la Unidad Administrativa Responsable" class="form-control" name="uar">
			                        <option value=""></option>
			                        @foreach($roles as $role)
			                        	<option value="{{ $role->id }}" @if($role->id == $role_id) selected @endif> {{ $role->name }}</option>
			                        @endforeach
			                    </select>
			                </div>
			                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
			                	<button type="submit" class="btn btn-primary">Filtrar</button>
			                	<a role="button" href="{{ route('resultados.index') }}" class="btn btn-info">Borrar filtro</a>
			                </div>
			            </div>
					</form>
				</div>
			</div>
		</div>
	@endcan
	@foreach($reports as $report)
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="panel">
					<form class="form-horizontal form-padding">
						<div class="panel-body">
							<div class="panel-heading">
								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					                <h3 class="panel-title">Reporte: <strong>{{ $report['theme_result'] }}</strong></h3>
					            </div>
					            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					                <h3 class="panel-title text-right" title="{{ $report['role'] }}">Área: <strong>{{ $report['role'] }}</strong></h3>
					            </div>
			                </div>
			            </div>
		                <div class="panel-body">
		                	@if(isset($report['goals']))
			                	@if(count($report['goals']) > 0)
				                	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						                <div class="table-responsive">
									        <table id="goals" class="table table-striped table-bordered" style="width: 100%">
									        	<thead>
									        		<tr>
										                <th colspan="3">Metas</th>
										             </tr>
									        	</thead>
									        	<tbody>
								        			<tr>
										             	@foreach($report['goals'] as $goal)
											             	<td>
											             		{{ $goal['goal_txt'] }}
											             	</td>
										             	@endforeach
										             </tr>
										             <tr>
										             	@foreach($report['goals'] as $goal)
											             	<td>
											             		{{ $goal['goal_unit'] }}
											             	</td>
										             	@endforeach
										             </tr>
									        	</tbody>
									        </table>
									    </div>
									</div>
								    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
									    <div class="table-responsive">
									        <table id="results" class="table table-striped table-bordered" style="width: 100%">
									        	<thead>
									        		<tr>
										                <th colspan="3">Avance al momento</th>
										             </tr>
									        	</thead>
									        	<tbody>
									        		<tr>
										             	@foreach($report['goals'] as $goal)
											             	<td>
											             		{{ $goal['goal_txt'] }}
											             	</td>
										             	@endforeach
										             </tr>
										             <tr>
										             	@foreach($report['goals'] as $goal)
											             	<td>
											             		{{  $goal['total_value'] .' ('. $goal['percent'] .')' }}
											             	</td>
										             	@endforeach
										             </tr>
									        	</tbody>
									        </table>
									    </div>
									</div>
							    @endif
							@else
							    <div class="table-responsive">
							        <table id="example" class="table table-striped" style="width: 100%">
							        	<thead>
							        		<th style="text-align: left;">{{ isset($report['total_value']) ? 'Total: '. $report['total_value'] : '' }}</th>
							        	</thead>
							        </table>
							    </div>
							@endif
						</div>
						<div class="panel-footer text-right">
							<a role="button" href="{{ route('resultados.show', $report['id']) }}" class="btn btn-primary">Ampliar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endforeach
@endsection