@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO | Acceso al sistema')

@section('titulo_pagina', 'Roles')

@section('customcss')
	<link href="/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/plugins/x-editable/css/bootstrap-editable.css" rel="stylesheet">
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
    	@if(session()->has('info'))
        	<div class="panel-heading">
	        	<div class="alert alert-success">{{ session('info') }}
	        		<button class="close" data-dismiss="alert">
                    	<i class="pci-cross pci-circle"></i>
                	</button>
	        	</div>
		    </div>
		    <br>
	    @endif
        @can('create_roles')
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            Nuevo Rol
        </a>
        @endcan

        <table id="table-roles"
	               data-search="true"
	               data-show-refresh="true"
	               data-show-toggle="true"
	               data-show-columns="true"
	               data-sort-name="id"
	               data-page-list="[5, 10, 20]"
	               data-page-size="5"
	               data-pagination="true"
	               data-show-pagination-switch="true"
	               data-locale="es-MX">
	    	<thead>
	    		<tr>
	    			<th class="col-sm-1">#</th>
	    			<th>Rol</th>
	    			<th class="col-lg-3">Acciones</th>
	    		</tr>
	    	</thead>
	    	<tbody>
                @foreach($roles as $role)
	                <tr>
	                    <td>{{ $loop->iteration }}</td>
	                    <td>{{ $role->name }}</td>
	                    <td>
	                        @can('show_roles')
	                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-primary">
	                                Ver
	                            </a>
	                        @endcan
	                        @can('edit_roles')
	                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
	                                Editar
	                            </a>
	                        @endcan
	                        @can('delete_roles')
	                            <form class="delete" action="{{ route('roles.destroy', $role->id) }}" style="display: inline;" method="POST">
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
	    </table>

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

		    $('#table-roles').bootstrapTable();
		});

		$(document).ready(function() {
			$("#table-roles").on('click', '.delete', function(e){
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