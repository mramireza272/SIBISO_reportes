@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Editar Formulario')

@section('customcss')
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
	    	$("#example").on('click', '.col-info', function(e){
                e.preventDefault();
                var item_id = $(this).attr('value');
                $.get('/formularios/nuevaColumna/'+ item_id, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    $('#col').show();
				    var input = '<th style="padding:0px 12px;"><input class="form-control" type="text" name="col_'+ data.id +'" data-type="rol" data-id="'+ data.id +'" value="'+ data.columns +'" /></th>';
				    $("#col").append(input);
				    $('#removeCol').attr('data-item', data.item_rol_id);
				    $('#removeCol').attr('data-structure', data.id);
			    });
            });

            $("#example").on('click', '.col-danger', function(e){
                e.preventDefault();
                var item_rol_id = $(this).attr('data-item');
                var rol_structure_item = $(this).attr('data-structure');
                $.get('/formularios/eliminarColumna/'+ item_rol_id +'/'+ rol_structure_item, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    data = data.split('&');
				    var input = "col_"+ data[0];
				    var structure = "";
				    var item = "";

				    if(data.length > 1) {
				    	item = data[1];
				    	structure = data[2];
				    }

				    $('input[name='+ input +']').remove();
				    $('#removeCol').attr('data-item', item);
				    $('#removeCol').attr('data-structure', structure);
			    });
            });

            $("#example").on('click', '.row-info', function(e){
                e.preventDefault();
                var id = $(this).attr('data-id');
                var rol_id = $(this).attr('data-rol');
                var parent_id = $(this).attr('data-parent');
                var print_row = $(this).attr('data-row');
                $.get('/formularios/nuevaFila/'+ rol_id +'/'+ parent_id, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    var input = '<tr><td style="padding:12px;"><input class="form-control" type="text" name="row_'+ data.id +'" data-type="item" data-id="'+ data.id +'" value="'+ data.item +'" /></td></tr>';

				    if(data.parent_id === null) {
				    	$('#rowChilds_'+ id).show();
				    	$('#rowChilds_'+ id).append(input);
				    } else if(print_row == 'child') {
				    	$('#rowSubChilds_'+ id).show();
				    	$('#rowSubChilds_'+ id).append(input);
				    } else if(print_row == 'childlast') {
				    	$('#rowSubChildsLast').show();
				    	$('#rowSubChildsLast').append(input);
				    } else {
				    	$('#rowChilds_'+ id).show();
				    	$('#rowChilds_'+ id).append(input);
				    }

				    $('.row-danger[data-item="' + parent_id + '"][data-id="'+ id +'"]').attr('data-item', data.parent_id).attr('data-id', data.id);
			    });
            });

            $("#example").on('click', '.row-danger', function(e){
                e.preventDefault();
                var item_id = $(this).attr('data-id');
                var parent_id = $(this).attr('data-item');
                $.get('/formularios/eliminarFila/'+ parent_id +'/'+ item_id, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    data = data.split('&');
				    var input = "row_"+ data[0];
				    var item = "";
				    var id = "";

				    if(data.length > 1) {
				    	id = data[1];
				    	item = data[2];
				    }

				    $('input[name='+ input +']').parent().parent().remove();
				    $('.row-danger[data-item="' + parent_id + '"][data-id="'+ item_id +'"]').attr('data-item', item).attr('data-id', id);
			    });
            });

            $("#example").on('change', 'input[type=text]', function(e){
		    	e.preventDefault();
		    	var params = {
		        	"id" : $(this).attr('data-id'),
		        	"type" : $(this).attr('data-type'),
		        	"column" : $(this).val(),
		            "_token" : '{{ csrf_token() }}'
		        };
		    	$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: "{{ url('/formularios/actualizarNombre') }}",
					data: params,
					success: function(data){
						console.log(data);
					},
				    error: function(data, textStatus, errorThrown) {
				        console.log('message=:' + data + ', text status=:' + textStatus + ', error thrown:=' + errorThrown);
				    }
				});
		    });

		    $("#example").on('change', 'input[type=checkbox]', function(e){
		    	e.preventDefault();
		    	var params = {
		        	"id" : $(this).attr('id'),
		        	"checked" : this.checked,
		            "_token" : '{{ csrf_token() }}'
		        };
		    	$.ajax({
					type: 'PUT',
					dataType: 'JSON',
					url: "{{ url('/formularios/actualizarEditable') }}",
					data: params,
					success: function(data){
						console.log(data);
					},
				    error: function(data, textStatus, errorThrown) {
				        console.log('message=:' + data + ', text status=:' + textStatus + ', error thrown:=' + errorThrown);
				    }
				});
		    });
	    });
	</script>
	<script src="/plugins/pace/pace.min.js"></script>
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	        <div class="panel">
	        	@if(session()->has('info'))
			    	<div class="panel">
			        	<div class="alert alert-success">{!! session('info') !!}
			        		<button class="close" data-dismiss="alert">
	                        	<i class="pci-cross pci-circle"></i>
	                    	</button>
			        	</div>
				    </div>
			    @endif
	        	<form method="POST" enctype="multipart/form-data" class="form-horizontal form-padding">
	                  {!! method_field('PUT') !!}
	                  <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
	                  @include('forms.form', ['action' => 'edit'])
				</form>
			</div>
	    </div>
	</div>
@endsection