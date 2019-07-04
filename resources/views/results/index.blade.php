@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Resultados')

@section('customcss')
	<style>
		table {
	      table-layout:`fixed;
	    }

	    table thead, th, tbody, td {
	      text-align: center;
	    }
    </style>
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
	    });
	</script>
@endsection

@section('content')
	@foreach($reports as $report)
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="panel">
					<form class="panel-body form-horizontal form-padding">
						<div class="panel-heading">
							<div class="col-md-6">
				                <h3 class="panel-title">Reporte: <strong>{{ $report['theme_result'] }}</strong></h3>
				            </div>
				            <div class="col-md-6">
				                <h3 class="panel-title text-right">Área: <strong>{{ $report['role'] }}</strong></h3>
				            </div>
		                </div>
		                <div class="panel-body">
		                	@isset($report['goals'])
			                	@if(count($report['goals']) > 0)
				                	<div class="col-md-6">
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
								    <div class="col-md-6">
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
											             		{{ $report['total_value'] .' ('. $goal['percent'] .')' }}
											             	</td>
										             	@endforeach
										             </tr>
									        	</tbody>
									        </table>
									    </div>
									</div>
							    @else
								    <div class="table-responsive">
								        <table id="example" class="table table-striped" style="width: 100%">

								        </table>
								    </div>
							    @endif
						    @endisset
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