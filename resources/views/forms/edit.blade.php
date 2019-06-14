@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Editar Reporte')

@section('customcss')
@endsection

@section('customjs')
	<script type="text/javascript">
	    $(document).ready(function(){
	    	$("#example").on('click', '.col-info', function(e){
	    		alert('col info');
                e.preventDefault();
                var item_id = $(this).attr('value');
                $.get('/formularios/nuevaColumna/'+ item_id, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    $('#col').show();
				    var input = '<th style="padding:0px 12px;"><input type="text" name="col_'+ data.id +'" data-type="rol" data-id="'+ data.id +'" value="'+ data.columns +'" /></th>';
				    $("#col").append(input);
				    $('#removeCol').attr('data-item', data.item_rol_id);
				    $('#removeCol').attr('data-structure', data.id);
			    });
            });

            $("#example").on('click', '.col-danger', function(e){
            	alert('col danger');
                e.preventDefault();
                var item_rol_id = $(this).attr('data-item');
                var rol_structure_item = $(this).attr('data-structure');
                $.get('/formularios/eliminarColumna/'+ item_rol_id +'/'+ rol_structure_item, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    alert(data);
				    data = data.split('&');
				    var input = "col_"+ data[0];
				    var structure = "";
				    var item = "";

				    if(data.length > 1) {
				    	item = data[1];
				    	structure = data[2]
				    }

				    $('input[name='+ input +']').remove();
				    $('#removeCol').attr('data-item', item);
				    $('#removeCol').attr('data-structure', structure);
			    });
            });

            $("#example").on('click', '.row-info', function(e){
            	alert('row info');
                e.preventDefault();
                var rol_id = $(this).attr('data-rol');
                var parent_id = $(this).attr('data-parent');
                $.get('/formularios/nuevaFila/'+ rol_id +'/'+ parent_id, function(data){
				    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
				    $('#row').show();
				    var input = '<tr>td style="padding:0px 12px;"><input type="text" name="row_'+ data.id +'" data-type="item" data-id="'+ data.id +'" value="'+ data.item +'" /></td></tr>';
				    $("#row").append(input);
				    $('#removeRow').attr('data-rol', data.rol_id);
				    $('#removeRow').attr('data-parent', data.parent_id);
			    });
            });

            $("#example").on('change', 'input[type=text]', function(e){
	        	alert('aqui');
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
	        	alert('check');
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
	    	@if(session()->has('info'))
		    	<div class="panel">
		        	<div class="alert alert-success">{!! session('info') !!}
		        		<button class="close" data-dismiss="alert">
                        	<i class="pci-cross pci-circle"></i>
                    	</button>
		        	</div>
			    </div>
		    @endif
	        <div class="panel">
	        	<form method="POST" action="{{ route('formularios.update', $rol->id) }}" enctype="multipart/form-data" class="form-horizontal form-padding">
	                  {!! method_field('PUT') !!}
	                  <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
	                  @include('forms.form', ['btnText' => 'Actualizar', 'action' => 'edit'])
				</form>
			</div>
	    </div>
	</div>
@endsection