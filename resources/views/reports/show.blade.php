@extends('templates.master')

@section('titulo', 'Sistema de Reportes SIBISO')

@section('titulo_pagina', 'Ver Reporte')

@section('customcss')
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
  <!--Pace - Page Load Progress Par [OPTIONAL]-->
  <link href="/plugins/pace/pace.min.css" rel="stylesheet">
@endsection

@section('customjs')
	<script src="/plugins/pace/pace.min.js"></script>
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