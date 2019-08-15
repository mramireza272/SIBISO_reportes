@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Registros')

@section('customcss')
	<link href="/plugins/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/plugins/datatables/media/css/dataTables.bootstrap.min.css">
    <link href="/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css">
    <link href="/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
    <style>
        table td {
        	word-wrap: break-word;
            max-width: 400px;
        }
    </style>
@endsection

@section('customjs')
	<script src="/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="application/javascript" >
		$(document).ready(function() {
		    $('select').chosen({no_results_text: "Sin resultados encontrados", width: "100%", allow_single_deselect: true});

		    $('.display').DataTable({
		    	"language": {
		            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
		        },
		        "responsive": true,
		        "paging"    : true,
		        "ordering"	: false
		    });

		    $(".display").on('click', '.delete', function(e){
		    	e.preventDefault();
		        var $form = $(this);
			    $('#confirm').modal({ backdrop: 'static', keyboard: false })
			        .on('click', '#delete-btn', function(){
			            $form.submit();
			    });
		    });
		});
	</script>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			@if(session()->has('info'))
		      	<div class="panel-heading">
		        	<div class="alert alert-success">{{ session('info') }}
		          		<button class="close" data-dismiss="alert">
		                    <i class="pci-cross pci-circle"></i>
		                </button>
		        	</div>
		    	</div>
		  	@endif
			<div class="panel">
				<form method="POST" action="{{ route('registros.search') }}" class="panel-body form-horizontal form-padding">
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
		                	<a role="button" href="{{ route('registros.index') }}" class="btn btn-info">Borrar filtro</a>
		                </div>
		            </div>
				</form>
			</div>
		</div>
	</div>
	@foreach($records as $record)
	<div class="panel">
		<div class="panel-heading">
		    <h3 class="panel-title"><strong>{{ isset($record['name']) ? $record['name'] : '' }}</strong></h3>
		</div>
		<div class="panel-body">
			<div class="row">
	            <div class="table-responsive">
			    	<table id="example_{{ $record['id'] }}" class="display" style="width:100%">
				        <thead>
				            <tr>
				                <th>#</th>
				                <th>Fecha Inicio</th>
				                <th>Fecha Fin</th>
				                <th>Fecha y hora de creación</th>
				                <th>Última edición</th>
				                <th>Autoriza</th>
				                <th>Estatus</th>
				                <th>Acciones</th>
				            </tr>
				        </thead>
				        <tbody>
			        	@foreach($record['records'] as $report)
				            <tr>
				            	<td>{{ $loop->iteration }}</td>
				                <td>{{ $report->date_start }}</td>
				                <td>{{ $report->date_end }}</td>
				                <td>{{ $report->created_at }}</td>
				                <td>{{ $report->user->email .' | '. $report->updated_at }}</td>
				                <td>{{ ($report->status == true) ? '' : $report->authorize->email }}</td>
				                <td>{{ ($report->status == 1) ? 'PENDIENTE' : 'VALIDADO' }}</td>
				                <td>
				                	<a href="{{ route('registros.show', $report->id) }}" class="btn btn-sm btn-primary">
		                                Ver
		                            </a>
				                	<a href="{{ route('registros.edit', $report->id) }}" class="btn btn-sm btn-warning">
	                                	Editar
	                            	</a>
				                	<form class="delete" style="display: inline;" method="POST" action="{{ route('registros.destroy', $report->id) }}">
	                                    {!! method_field('DELETE') !!}
						                <input type="hidden" name="_token" value="{{ csrf_token() }}">
						                <button title="Eliminar" class="btn btn-sm btn-danger">
			        						Eliminar
			        					</button>
					                </form>
					            </td>
				            </tr>
			        	@endforeach
				        </tbody>
				        <tfoot>
				        	<tr>
				                <th>#</th>
				                <th>Fecha Inicio</th>
				                <th>Fecha Fin</th>
				                <th>Fecha y hora de creación</th>
				                <th>Última edición</th>
				                <th>Autoriza</th>
				                <th>Estado</th>
				                <th>Acciones</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>
		</div>
	</div>
	@endforeach

	<div class="modal" id="confirm">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" style="text-align: center;">Atención</h4>
	            </div>
	            <div class="modal-body" style="text-align: center;">
	                <p>¿Está seguro(a) de eliminar?</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
		            <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
@endsection