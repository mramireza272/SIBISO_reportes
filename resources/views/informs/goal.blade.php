@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Nueva Meta')

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
					url: "{{ url('/informes/updateMeta') }}",
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
					url: "{{ url('/informes/updateMeta') }}",
					data: params,
					success: function(data){
						console.log(data);
					}
				});
		    });
		});
	</script>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			@if(session()->has('info'))
		    	<div class="panel">
		        	<div class="alert alert-success">{{ session('info') }}
		        		<button class="close" data-dismiss="alert">
	                    	<i class="pci-cross pci-circle"></i>
	                	</button>
		        	</div>
			    </div>
		    @endif
		    <div class="panel">
		    	<div class="panel-heading">
                    <h3 class="panel-title"><strong>{{ $result->rol->name .' - '. $result->theme_result }}</strong></h3>
                </div>
                <div class="panel-body">
					<div class="row">
			            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
					    	<table id="example" class="display" style="width:100%">
						        <thead>
						            <tr>
						                <th class="text-center" style="width: 5%">#</th>
						                <th style="width: 45%">Meta</th>
						                <th style="width: 25%">Unidad</th>
						            </tr>
						        </thead>
						        <tbody>
					        	@foreach($goals as $goal)
						            <tr>
						            	<td>{{ $loop->iteration }}</td>
						                <td>
						                	<strong><input class="form-control" type="text" name="goal_txt" value="{{ $goal->goal_txt }}" data-id="{{ $goal->id }}"/></strong>
						                </td>
						                <td><strong><input class="form-control" type="text" name="goal_unit" value="{{ $goal->goal_unit }}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-id="{{ $goal->id }}"/></strong>
						                </td>
						            </tr>
					        	@endforeach
						        </tbody>
						    </table>
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
					    <label class="col-md-3 control-label" for="goal_txt"><strong>Nombre*</strong></label>
					    <div class="col-md-9">
					        <input type="text" id="goal_txt" name="goal_txt" class="form-control" placeholder="Ingrese el nombre de la meta" value="{{ old('goal_txt') }}" />
					        {!! $errors->first('goal_txt', '<small class="help-block text-danger">:message</small>') !!}
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-md-3 control-label" for="goal_unit"><strong>Unidad*</strong></label>
					    <div class="col-md-9">
					        <input type="text" id="goal_unit" name="goal_unit" class="form-control" placeholder="Ingrese la unidad" value="{{ old('goal_unit') }}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
					        {!! $errors->first('goal_unit', '<small class="help-block text-danger">:message</small>') !!}
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