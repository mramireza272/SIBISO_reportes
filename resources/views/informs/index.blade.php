@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Reportes')

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
		        "order": [],
		        "columnDefs": [
  					{ targets: 'no-sort', orderable: false }
				]
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
		<div class="panel-body text-right">
			@can('create_form')
		        <a href="{{ route('informes.create') }}" class="btn btn-primary">
		            Nuevo Reporte
		        </a>
	        @endcan
		</div>
		<div class="panel-body">
			<div class="row">
	           <div class="table-responsive">
			    	<table id="example" class="display" style="width:100%">
				        <thead>
				            <tr>
				                <th class="no-sort" style="text-align: center; width: 5%;">#</th>
				                <th style="width: 35%">Unidad Administrativa Responsable</th>
				                <th class="no-sort" style="width: 20%;">Tema</th>
				                <th class="no-sort" style="width: 20%;">Descripción</th>
				                <th class="no-sort" style="width: 20%;">Acciones</th>
				            </tr>
				        </thead>
				        <tbody>
		        		@foreach ($results as $result)
				            <tr>
				            	<td style="text-align: center;">{{ $loop->iteration }}</td>
				                <td>{{ $result->name }}</td>
				                <td>{{ $result->theme_result }}</td>
				                <td>{{ $result->description }}</td>
				                <td>
				                	<a href="{{ route('informes.show', $result->id) }}" class="btn btn-sm btn-primary">
		                                Ver
		                            </a>
				                	@can('edit_form')
					                	<a href="{{ route('informes.creategoal', $result->id) }}" class="btn btn-sm btn-info">
			                                Meta
			                            </a>
					                	<a href="{{ route('informes.createvariable', $result->id) }}" class="btn btn-sm btn-info">
		                                	Variable
		                            	</a>
		                            	<a href="{{ route('informes.edit', $result->id) }}" class="btn btn-sm btn-warning">
		                                	Editar
		                            	</a>
	                            	@endcan
					            </td>
				            </tr>
			            @endforeach
				        </tbody>
				        <tfoot>
				        	<tr>
				                <th style="text-align: center;">#</th>
				                <th>Unidad Administrativa Responsable</th>
				                <th>Tema</th>
				                <th>Descripción</th>
				                <th>Acciones</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>
		</div>
	</div>
@endsection