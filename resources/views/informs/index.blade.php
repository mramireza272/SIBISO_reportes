@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

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
			                <th class="text-center" style="width: 5%">#</th>
			                <th style="width: 35%">Unidad Administrativa Responsable</th>
			                <th style="width: 20%">Tema</th>
			                <th style="width: 20%">Descripción</th>
			                <th style="width: 20%">Acciones</th>
			            </tr>
			        </thead>
			        <tbody>
		        	@foreach($results as $result_list)
		        		@foreach ($result_list as $result)
				            <tr>
				            	<td>{{ $loop->iteration }}</td>
				                <td>{{ $result->rol->name }}</td>
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
	                            	{{-- @can('delete_form')
					                	<form class="delete" style="display: inline;" method="POST" action="{{ route('informes.destroy', $result->id) }}">
		                                    {!! method_field('DELETE') !!}
							                <input type="hidden" name="_token" value="{{ csrf_token() }}">
							                <button title="Eliminar" class="btn btn-sm btn-danger">
				        						Eliminar
				        					</button>
						                </form>
					                @endcan --}}
					            </td>
				            </tr>
			            @endforeach
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