@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Ver Resultado Ampliado')

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
	    	$('.fechapicker').datetimepicker({
	    		minView: 2,
	    		pickTime: false,
	    		language: 'es',
	    		format: 'yyyy-mm-dd',
	    		autoclose: true,
	        	todayBtn: true,
	        	pickerPosition: "bottom-left"
	    	});

	    	$('#search').on('click', function(e) {
				e.preventDefault();
				$("#results").empty();
				$("#results").hide();
				var params = {
		        	"result_id" : $(this).attr('data-id'),
		        	"date_start" : $('#date_start').val(),
		        	"date_end" : $('#date_end').val(),
		            "_token": '{{ csrf_token() }}'
		        };
	            $.ajax({
	                url:        '{{ url("/resultados/generaravance") }}',
	                data:       params,
	                type:       'POST',
	                dataType:   'json',
	                success:    function(response){
	                	if($.isEmptyObject(response.error)){
	                    	$("#results").show();
	                    	html = '';

	                    	if(response.result.goals.length > 0) {
	                    		html += '<div class="col-md-6"><div class="table-responsive"><table id="goals" class="table table-striped table-bordered" style="width: 100%"><thead><tr><th colspan="3">Metas</th></tr></thead><tbody><tr>';

	                    		for (var i = 0; i < response.result.goals.length; i++) {
	                    			html += '<td>'+ response.result.goals[i].goal_txt +'</td>';
	                    		}

								html += '</tr><tr>';

								for (var i = 0; i < response.result.goals.length; i++) {
	                    			html += '<td>'+ response.result.goals[i].goal_unit +'</td>';
	                    		}

								html += '</tr></tbody></table></div></div><div class="col-md-6"><div class="table-responsive"><table id="results" class="table table-striped table-bordered" style="width: 100%"><thead><tr><th colspan="3">Avance al periodo de búsqueda</th></tr></thead><tbody><tr>';

								for (var i = 0; i < response.result.goals.length; i++) {
	                    			html += '<td>'+ response.result.goals[i].goal_txt +'</td>';
	                    		}

								html += '</tr><tr>';

								for (var i = 0; i < response.result.goals.length; i++) {
	                    			html += '<td>'+ response.result.total_value + ' ('+ response.result.goals[i].percent +')</td>';
	                    		}

								html += '</tr></tbody></table></div></div>';
						    } else {
							    html += '<div class="table-responsive"><table id="example" class="table table-striped" style="width: 100%"><thead><th style="text-align: left;">Total: '+ response.result.total_value +'</th></thead></table></div>';
						    }

						    $("#results").html(html);
	                    } else {
	                        printErrorMsg(response.error);
	                    }
		            }
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
	        	<div class="alert alert-danger print-error-msg" style="display: none;">
					<ul></ul>
				</div>
	        	<form class="panel-body form-horizontal form-padding">
	        		<div class="panel-heading">
			            <h3 class="panel-title">Reporte: <strong>{{ $result->theme_result }}</strong></h3>
	                </div>
	                <div class="panel-heading">
			            <h3 class="panel-title">Área: <strong>{{ $result->rol->name }}</strong></h3>
	                </div>
					<div class="panel-body">
						<div class="form-group">
					        <label class="control-label col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left"><strong>Periodo al que corresponde la información: *</strong></label>
					        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left">
					            <input autocomplete="off" type='text' class="form-control date fechapicker" id="date_start" name="date_start" value="" placeholder="Fecha de inicio del periodo" />
					            {!! $errors->first('date_start', '<small class="help-block text-danger">:message</small>') !!}
					        </div>
					        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left">
					            <input autocomplete="off" type='text' class="form-control date fechapicker" id="date_end" name="date_end" value="" placeholder="Fecha del fin del periodo" />
					            {!! $errors->first('date_end', '<small class="help-block text-danger">:message</small>') !!}
					        </div>
					        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 text-left">
					        	<button title="Buscar" id="search" class="btn btn-sm btn-info" data-id="{{ $result->id }}">Buscar</button>
					        </div>
					    </div>
					    <div id='results' style="display: none;">
						    <div class="form-group">

						    </div>
						</div>
		            </div>
					<div class="panel-footer text-right">
						<a role="button" href="javascript:history.back(1)" class="btn btn-primary">Regresar</a>
					</div>
				</form>
			</div>
	    </div>
	</div>
@endsection