@extends('layouts.default')


@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/datepicker/datepicker.css" type="text/css" cache="false" />

<div class="row">

	<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<div class="navbar-brand">Informe Recibos</div>
		</div>
	</nav>

	<div class="col-sm-6">
		<section class="panel panel-default">
			<header class="panel-heading font-bold">{{ $title }}</header>
			<div class="panel-body">
				{{ Form::open(array('route' => 'ventasmovimientos.reciboshow', "autocomplete"=>"off"
, 'class' => 'panel-body wrapper-lg', 'target' => '_blank')) }}


          @if (isset($flash_message))
          <div class="alert alert-warning">{{ $flash_message }}</div>
          @endif


								<div class="row">
									<div class="col-xs-5">
									<label>Fecha desde</label>
										{{ Form::text('fecha_desde', '', array('class' => 'datepicker-input form-control input-lg', 'id' =>'fecha_desde', 'placeholder' => 'Fecha', 'data-date-format' => 'dd-mm-yyyy')) }}
										<br> <?php
											if ($errors->first('fecha_desde')) {
													?>
												<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-ban-circle"></i> <strong>Ups... error!</strong>
												<div class="alert-link">{{ $errors->first('fecha_desde') }}</div>
											</div>
										<?php } ?>

									</div>
								</div>

								<div class="row">
									<div class="col-xs-5">
									<label>Fecha hasta</label>
										{{ Form::text('fecha_hasta', '', array('class' => 'datepicker-input form-control input-lg', 'id' =>'fecha_hasta', 'placeholder' => 'Fecha', 'data-date-format' => 'dd-mm-yyyy')) }}
										<br> <?php
											if ($errors->first('fecha_hasta')) {
													?>
												<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-ban-circle"></i> <strong>Ups... error!</strong>
												<div class="alert-link">{{ $errors->first('fecha_hasta') }}</div>
											</div>
										<?php } ?>

									</div>
								</div>


								<div class="row">
								<div class="col-xs-8">
								<label>Empresa</label>
									{{ Form::select( 'empresas_id', Empresa::All()->
												lists('empresa', 'id'), Input::get('empresa'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
										<br> <?php
											if ($errors->first('empresas_id')) {
													?>
												<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-ban-circle"></i> <strong>Ups... error!</strong>
												<div class="alert-link">{{ $errors->first('empresas_id') }}</div>
											</div>
										<?php } ?>

								</div>
								</div>

<br>
				{{ Form::submit('Buscar movimientos Recibos', array('class' => 'btn btn-primary')) }}

				{{ Form::close() }}
			</div>
		</section>
	</div>
</div>


<script src="/js/app.v2.js"></script>

<script>

var jq = jQuery.noConflict();
    jq(document).ready( function(){





  });


});


</script>

<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
