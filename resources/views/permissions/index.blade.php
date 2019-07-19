@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Permisos')

@section('customcss')
	<link href="/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/plugins/x-editable/css/bootstrap-editable.css" rel="stylesheet">
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
	    <div class="panel-body">
	        @can('create_roles')
	        <a href="{{ route('permisos.create') }}" class="btn btn-primary">
	            Nuevo Permiso
	        </a>
	        @endcan

	        <table id="table-permisos"
		               data-search="true"
		               data-show-refresh="true"
		               data-show-toggle="true"
		               data-show-columns="true"
		               data-sort-name="id"
		               data-page-list="[25, 50, 100]"
		               data-page-size="10"
		               data-pagination="true"
		               data-show-pagination-switch="true"
		               data-locale="es-MX">
		    	<thead>
		    		<tr>
		    			<th class="col-sm-1">#</th>
		    			<th>Permiso</th>
		    			<th>Descripción</th>
		    			<th class="col-lg-3">Acciones</th>
		    		</tr>
		    	</thead>
		    	<tbody>
	                @foreach($permissions as $permission)
		                <tr>
		                    <td>{{ $loop->iteration }}</td>
		                    <td>{{ $permission->name }}</td>
		                    <td>{{ $permission->description }}</td>
		                    <td>
		                        @can('show_roles')
		                            <a href="{{ route('permisos.show', $permission->id) }}" class="btn btn-sm btn-primary">
		                                Ver
		                            </a>
		                        @endcan
		                        @can('edit_roles')
		                            <a href="{{ route('permisos.edit', $permission->id) }}" class="btn btn-sm btn-warning">
		                                Editar
		                            </a>
		                        @endcan
		                        @can('delete_roles')
		                            <form class="delete" action="{{ route('permisos.destroy', $permission->id) }}" style="display: inline;" method="POST">
			        					{!! method_field('DELETE') !!}
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
				        				<button title="Eliminar" class="btn btn-sm btn-danger">
				        					Eliminar
				        				</button>
				        			</form>
		                        @endcan
		                    </td>
		                </tr>
	                @endforeach
	            </tbody>
	            <tfoot>
		    		<tr>
		    			<th>#</th>
		    			<th>Permiso</th>
		    			<th>Descripción</th>
		    			<th>Acciones</th>
		    		</tr>
		    	</tfoot>
		    </table>
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

@section('customjs')
    <script src="/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/plugins/bootstrap-table/locale/bootstrap-table-es-MX.min.js"></script>
    <script type="text/javascript">
    	$(document).on('nifty.ready', function() {
		    jQuery.fn.bootstrapTable.defaults.icons = {
		        paginationSwitchDown: 'pli-arrow-down',
		        paginationSwitchUp: 'pli-arrow-up',
		        refresh: 'pli-repeat-2',
		        toggle: 'pli-layout-grid',
		        columns: 'pli-check',
		        detailOpen: 'psi-add',
		        detailClose: 'psi-remove'
		    }

		    $('#table-permisos').bootstrapTable();
		});

		$(document).ready(function() {
			$("#table-permisos").on('click', '.delete', function(e){
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