@extends('templates.master')

@section('titulo', 'Sistema de Reporte de Servicios Sociales SIBISO')

@section('titulo_pagina', 'Ver Registro')

@section('customcss')
	<style>
    	textarea {
      		resize: none;
    	}
    </style>
@endsection

@section('customjs')
@endsection

@section('content')
    <div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
	        <div class="panel">
	        	<form class="form-horizontal form-padding">
              		@include('records.form', ['action' => 'show'])
				</form>
			</div>
	    </div>
	</div>
@endsection