@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', $variable)

@section('customcss')
@endsection

@section('customjs')
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
	        	<form method="POST" action="{{ route('informes.storevariable') }}" class="panel-body form-horizontal form-padding">
	        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<input type="hidden" name="formula_id" value="{{ $formulaResult->id }}">
                	<input type="hidden" name="result_id" value="{{ $result->id }}">
	        		<div class="panel-heading">
	                    <h3 class="panel-title"><strong>{{ $result->rol->name .' - '. $result->theme_result }}</strong></h3>
	                </div>
					<div class="panel-body">
		                <div class="table-responsive">
					        <table id="example" class="table table-striped" style="width: 100%">
					            @foreach ($rows as $row)
					                <thead>
					                    <tr>
					                        <th>
					                            {{ $row->item }}
					                        </th>
					                        @foreach ($row->cols as $col)
					                            <th>
					                                {{ $col->columns }}
					                            </th>
					                        @endforeach
					                    </tr>
					                </thead>
					                <tbody>
					                    @foreach ($row->childs as $ch)
					                        <tr>
					                            <td>
					                                {{ $ch->item }}
					                            	@foreach($row->cols as $innercol)
		    											<td>
			    											@if(isset($actives[$ch->id][$innercol->id]))
			    												@php($checked = 'checked')
			    											@else
			    												@php($checked = '')
			    											@endif
		  													@if($ch->editable == true)
		  														<input class="magic-checkbox" type="checkbox" name="check[]" id="check_{{ $ch->id .'_'. $innercol->id }}[]" value="{{ $ch->id .'_'. $innercol->id }}" {{ $checked }} />
		  														<label for="check_{{ $ch->id .'_'. $innercol->id }}[]"></label>
		  													@endif
		  												</td>
												    @endforeach
		    									</td>
					                        </tr>
						                    @foreach ($ch->childs as $sbch)
						                        <tr>
						                            <td>
						                                {{ $sbch->item }}
						                            </td>
						                            @foreach($row->cols as $innercol)
		    											<td>
			    											@if(isset($actives[$sbch->id][$innercol->id]))
			    												@php($checked = 'checked')
			    											@else
			    												@php($checked = '')
			    											@endif
			  												<input class="magic-checkbox" type="checkbox" name="check[]" id="check_{{ $sbch->id .'_'. $innercol->id }}[]" value="{{ $sbch->id .'_'. $innercol->id }}" {{ $checked }} />
			  												<label for="check_{{ $sbch->id .'_'. $innercol->id }}[]"></label>
		  												</td>
		  											@endforeach
						                        </tr>
						                    @endforeach
					                    @endforeach
					                </tbody>
					            @endforeach
					        </table>
					    </div>
		            </div>
					<div class="panel-footer text-right">
						{!! $errors->first('check', '<small class="help-block text-danger">:message</small>') !!}
						<a role="button" href="{{ route('informes.index') }}" class="btn btn-primary">Regresar</a>
						<button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar' }}</button>
					</div>
				</form>
			</div>
	    </div>
	</div>
@endsection