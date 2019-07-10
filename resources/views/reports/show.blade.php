@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Ver Registro')

@section('customcss')
@endsection

@section('customjs')
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	        <div class="panel">
	        	<form class="form-horizontal form-padding">
              @include('reports.form', ['action' => 'show'])
				</form>
			</div>
	    </div>
	</div>
@endsection