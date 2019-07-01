@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Reportes')

@section('customcss')
	<link href="/plugins/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="/plugins/datatables/media/css/dataTables.bootstrap.min.css">
    <link href="/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css">
    <link href="/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
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
@endsection
@section('customjs')
<script src="/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script>
	 	$(document).ready(function() {
		    $('#example').DataTable({
		    	"language": {
		            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
		        },
		        "responsive": true,
		        "paging"    : true,
		        "ordering"	: false
		    });

		    $("#example").on('click', '.delete', function(e){
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
	<div class="panel-heading">
	    <h2 class="panel-title">{{ isset($rol->name) ? $rol->name : '' }}</h2>
	</div>
	<div class="panel-body text-right">
		@canany(['create_ined', 'create_cgib', 'create_asc', 'create_sdh', 'create_iapp'])
			<a href="{{ route('reportes.create') }}" class="btn btn-primary">Nuevo Reporte</a>
		@endcanany
	</div>
	<div class="panel-body">
		<div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
		    	<table id="example" class="display" style="width:100%">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Fecha Inicio</th>
			                <th>Fecha Fin</th>
			                <th>Fecha y Hora de creación</th>
			                <th>Acciones</th>
			            </tr>
			        </thead>
			        <tbody>
		        	@foreach($reports as $report)
			            <tr>
			            	<td>{{ $loop->iteration }}</td>
			                <td>{{ $report->date_start }}</td>
			                <td>{{ $report->date_end }}</td>
			                <td>{{ $report->created_at }}</td>
			                <td>
			                	<a href="{{ route('reportes.show', $report->id) }}" class="btn btn-sm btn-primary">
	                                Ver
	                            </a>
	                            @php
	                            	$two_hours = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($report->created_at)));
	                            	$now = date("Y-m-d H:i:s");
	                            @endphp
	                            @if($now <= $two_hours)
		                            @canany(['edit_ined', 'edit_cgib', 'edit_asc', 'edit_sdh', 'edit_iapp'])
					                	<a href="{{ route('reportes.edit', $report->id) }}" class="btn btn-sm btn-warning">
		                                	Editar
		                            	</a>
	                            	@endcanany
	                            	@canany(['delete_ined', 'delete_cgib', 'delete_asc', 'delete_sdh', 'delete_iapp'])
					                	<form class="delete" style="display: inline;" method="POST" action="{{ route('reportes.destroy', $report->id) }}">
		                                    {!! method_field('DELETE') !!}
							                <input type="hidden" name="_token" value="{{ csrf_token() }}">
							                <button title="Eliminar" class="btn btn-sm btn-danger">
				        						Eliminar
				        					</button>
						                </form>
					                @endcanany
				                @endif
				            </td>
			            </tr>
		        	@endforeach
			        </tbody>
			    </table>

			</div>
		</div>
	</div>

	<div class="modal" id="confirm">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" style="text-align: center;">Atención</h4>
	            </div>
	            <div class="modal-body" style="text-align: center;">
	                <p>¿Está seguro de eliminar?</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
		            <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Eliminar</button>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection