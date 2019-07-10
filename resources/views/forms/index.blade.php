@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Formularios')

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
		{{-- @canany(['create_ined', 'create_cgib', 'create_asc', 'create_sdh', 'create_iapp'])
			<a href="{{ route('formularios.create') }}" class="btn btn-primary">Nuevo Formulario</a>
		@endcanany --}}
	</div>
	<div class="panel-body">
		<div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
		    	<table id="example" class="display" style="width:100%">
			        <thead>
			            <tr>
			                <th class="text-center" style="width: 5%">#</th>
			                <th style="width: 70%">Unidad Administrativa Responsable</th>
			                <th style="width: 25%">Acciones</th>
			            </tr>
			        </thead>
			        <tbody>
		        	@foreach($roles as $rol)
			            <tr>
			            	<td>{{ $loop->iteration }}</td>
			                <td>{{ $rol->name }}</td>
			                <td>
			                	<a href="{{ route('formularios.show', $rol->id) }}" class="btn btn-sm btn-primary">
	                                Ver
	                            </a>
	                            @can('edit_form')
				                	<a href="{{ route('formularios.edit', $rol->id) }}" class="btn btn-sm btn-warning">
	                                	Editar
	                            	</a>
                            	@endcan
                            	{{-- @can('delete_form')
				                	<form class="delete" style="display: inline;" method="POST" action="{{ route('formularios.destroy', $rol->id) }}">
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