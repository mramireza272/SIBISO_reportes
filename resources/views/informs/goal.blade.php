@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Nueva Meta')

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

		    $('.fechapicker').datetimepicker({
	    		minView: 2,
	    		pickTime: false,
	    		language: 'es',
	    		format: 'yyyy-mm-dd',
	    		autoclose: true,
	        	todayBtn: true,
	        	pickerPosition: "bottom-left"
	    	});

		    $("#example input[name=goal_txt]").on('change', function(e){
		    	e.preventDefault();
		    	var params = {
		        	"id" : $(this).attr('data-id'),
		        	"goal_txt" : $(this).val(),
		            "_token": '{{ csrf_token() }}'
		        };
		    	$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: "{{ route('informes.updategoal') }}",
					data: params,
					success: function(data){
						console.log(data);
					}
				});
		    });

		    $("#example input[name=goal_unit]").on('change', function(e){
		    	e.preventDefault();
		    	var params = {
		        	"id" : $(this).attr('data-id'),
		        	"goal_unit" : $(this).val(),
		            "_token": '{{ csrf_token() }}'
		        };
		    	$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: "{{ route('informes.updategoal') }}",
					data: params,
					success: function(data){
						console.log(data);
					}
				});
		    });

		    $("#example input[name=date_start]").on('change', function(e){
		    	e.preventDefault();
		    	var params = {
		        	"id" : $(this).attr('data-id'),
		        	"date_start" : $(this).val(),
		        	"date_end" : $(this).attr('data-end'),
		        	"type" : "start",
		            "_token": '{{ csrf_token() }}'
		        };
		    	$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: "{{ route('informes.updategoal') }}",
					data: params,
					success: function(data){
						if($.isEmptyObject(data.error)){
							console.log(data);
						} else {
	                        printErrorMsg(data.error);
	                    }
					}
				});
		    });

		    $("#example input[name=date_end]").on('change', function(e){
		    	e.preventDefault();
		    	var params = {
		        	"id" : $(this).attr('data-id'),
		        	"date_end" : $(this).val(),
		        	"date_start" : $(this).attr('data-start'),
		        	"type" : "end",
		            "_token": '{{ csrf_token() }}'
		        };
		    	$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: "{{ route('informes.updategoal') }}",
					data: params,
					success: function(data){
						if($.isEmptyObject(data.error)){
							console.log(data);
						} else {
	                        printErrorMsg(data.error);
	                    }
					}
				});
		    });

		    $("#example").on('click', '.delete', function(e){
		    	e.preventDefault();
		        var $form = $(this);
			    $('#confirm').modal({ backdrop: 'static', keyboard: false })
			        .on('click', '#delete-btn', function(){
			            $form.submit();
			    });
		    });

		    function printErrorMsg (msg) {
	            $(".print-error-msg").find("ul").html('');
	            $(".print-error-msg").css('display', 'block');

	            $.each( msg, function( key, value ) {
	                $(".print-error-msg").find("ul").append('<li>'+ value +'</li>');
	            });
	        }
		});
	</script>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
		    <div class="panel">
		    	@if(session()->has('info'))
			    	<div class="panel">
			        	<div class="alert alert-success">{{ session('info') }}
			        		<button class="close" data-dismiss="alert">
		                    	<i class="pci-cross pci-circle"></i>
		                	</button>
			        	</div>
				    </div>
			    @endif
		    	<div class="alert alert-danger print-error-msg" style="display: none;">
					<ul></ul>
				</div>
		    	<div class="panel-heading">
                    <h3 class="panel-title"><strong>{{ $result->rol->name .' - '. $result->theme_result }}</strong></h3>
                </div>
                <div class="panel-body">
					<div class="row">
			            <div class="table-responsive">
					    	<table id="example" class="display" style="width:100%">
						        <thead>
						            <tr>
						                <th class="text-center" style="width: 5%">#</th>
						                <th style="width: 40%">Meta</th>
						                <th style="width: 20%">Unidad</th>
						                <th style="width: 15%">Fecha Inicio</th>
						                <th style="width: 15%">Fecha Fin</th>
						                <th style="width: 5%">Acciones</th>
						            </tr>
						        </thead>
						        <tbody>
					        	@foreach($goals as $goal)
						            <tr>
						            	<td>{{ $loop->iteration }}</td>
						                <td>
						                	<strong><input class="form-control" type="text" name="goal_txt" value="{{ $goal->goal_txt }}" data-id="{{ $goal->id }}"/></strong>
						                </td>
						                <td><strong><input class="form-control" type="text" name="goal_unit" value="{{ number_format($goal->goal_unit) }}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-id="{{ $goal->id }}"/></strong>
						                </td>
						                <td>
						                	<input autocomplete="off" type='text' class="form-control date fechapicker" id="date_start" name="date_start" value="{{ $goal->date_start }}" placeholder="Fecha de inicio de la meta" data-id="{{ $goal->id }}" data-end="{{ $goal->date_end }}" />
						                </td>
						                <td>
						                	<input autocomplete="off" type='text' class="form-control date fechapicker" id="date_end" name="date_end" value="{{ $goal->date_end }}" placeholder="Fecha del fin de la meta" data-id="{{ $goal->id }}" data-start="{{ $goal->date_start }}" />
						                </td>
						                <td>
						                	@can('delete_form')
							                	<form class="delete" style="display: inline;" method="POST" action="{{ route('informes.destroyGoal') }}">
				                                    {!! method_field('DELETE') !!}
									                <input type="hidden" name="_token" value="{{ csrf_token() }}">
									                <input type="hidden" name="result_id" value="{{ $result->id }}">
									                <input type="hidden" name="id" value="{{ $goal->id }}">
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
							                <p>¿Está seguro(a) de eliminar?</p>
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
				</div>
			</div>
			<div class="panel">
				<form method="POST" action="{{ route('informes.storegoal') }}" class="panel-body form-horizontal form-padding">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="result_id" value="{{ $result->id }}">
					<div class="panel-heading">
	                    <h3 class="panel-title"><strong>{{ $result->rol->name .' - '. $result->theme_result }}</strong></h3>
	                </div>
					<div class="form-group">
					    <label class="control-label col-sm-3 col-md-3 col-lg-3 col-xl-3" for="goal_txt"><strong>Nombre*</strong></label>
					    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
					        <input type="text" id="goal_txt" name="goal_txt" class="form-control" placeholder="Ingrese el nombre de la meta" value="{{ old('goal_txt') }}" />
					        {!! $errors->first('goal_txt', '<small class="help-block text-danger">:message</small>') !!}
					    </div>
					</div>
					<div class="form-group">
					    <label class="control-label col-sm-3 col-md-3 col-lg-3 col-xl-3" for="goal_unit"><strong>Unidad*</strong></label>
					    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
					        <input type="text" id="goal_unit" name="goal_unit" class="form-control" placeholder="Ingrese la unidad" value="{{ old('goal_unit') }}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
					        {!! $errors->first('goal_unit', '<small class="help-block text-danger">:message</small>') !!}
					    </div>
					</div>
					<div class="form-group">
				        <label class="control-label col-sm-3 col-md-3 col-lg-3 col-xl-3"><strong>Periodo al que corresponde la meta: *</strong></label>
				        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-left">
				            <input autocomplete="off" type='text' class="form-control date fechapicker" id="date_start" name="date_start" value="{{ old('date_start') }}" placeholder="Fecha de inicio de la meta" />
				            {!! $errors->first('date_start', '<small class="help-block text-danger">:message</small>') !!}
				        </div>
				        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-left">
				            <input autocomplete="off" type='text' class="form-control date fechapicker" id="date_end" name="date_end" value="{{ old('date_end') }}" placeholder="Fecha del fin de la meta" />
				            {!! $errors->first('date_end', '<small class="help-block text-danger">:message</small>') !!}
				        </div>
				    </div>
					<div class="panel-footer text-right">
						<a role="button" href="{{ route('informes.index') }}" class="btn btn-primary">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection