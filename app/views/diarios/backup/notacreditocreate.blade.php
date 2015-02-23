@extends('layouts.default')


@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/datepicker/datepicker.css" type="text/css" cache="false" />

<div class="row">

	<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ URL::to('/') }}">Nota Credito</a>
		</div>
	</nav>

	<div class="col-sm-6">
		<section class="panel panel-default">
			<header class="panel-heading font-bold">Crear</header>
			<div class="panel-body">
				{{ Form::open(array('route' => 'ventasmovimientos.verfacturasparanc', "autocomplete"=>"off"
, 'class' => 'panel-body wrapper-lg')) }}


<div class="row">
<div class="col-xs-5">
	<label>Fecha</label>
		{{ Form::text('fecha', '', array('class' => 'datepicker-input form-control input-lg', 'id' =>'fecha', 'name' =>'fecha', 'placeholder' => 'Fecha', 'data-date-format' => 'dd-mm-yyyy')) }}
		<br> <?php
			if ($errors->first('fecha')) {
					?>
				<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-ban-circle"></i> <strong>Ups... error!</strong>
				<div class="alert-link">{{ $errors->first('fecha') }}</div>
			</div>
		<?php } ?>

	</div>
</div>

<div class="row">
<div class="col-xs-8">
<label>Cliente</label>
{{ Form::text('cliente', '', array('class' => 'form-control input-lg', 'id' =>'cliente', 'placeholder' => 'Ingrese un cliente')) }}
			{{ Form::hidden('clientes_id' , '0', array('id' =>'clientes_id')) }}

			<br> <?php
				if ($errors->first('clientes_id')) {
						?>
					<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-ban-circle"></i> <strong>Ups... error!</strong>
					<div class="alert-link">{{ $errors->first('clientes_id') }}</div>
				</div>
			<?php } ?>



</div>
</div>

<div class="row">
<div class="col-xs-8">
<label>Empresa</label>
	{{ Form::select( 'empresas_id', Empresa::All()->
				lists('empresa', 'id'), Input::get('empresa'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
</div>
</div>

<br>
<div class="row">
	<div class="col-xs-12">
		<label><h4>Proximos numeros Facturas</h4></label><br>
		<?

				$empresas = Empresa::All();

				// $empresasdocumentosnumeros = DB::table('empresasdocumentosnumeros')->where('ciudad', 'like', '%' . $term . '%')->get();



				foreach ($empresas as $empresa)
				{

						echo "<b>Empresa:</b>" . $empresa->empresa . "<br>";

								$empresasdocumentosnumeros = DB::table('empresasdocumentosnumeros')
									->where('empresas_id', '=', $empresa->id)
									->where('tiposdocumentos_id', '=', 6)
									->first();
								echo "Nota Credito A: " . $empresasdocumentosnumeros->numero . "<br>";

								$empresasdocumentosnumeros = DB::table('empresasdocumentosnumeros')
									->where('empresas_id', '=', $empresa->id)
									->where('tiposdocumentos_id', '=', 9)
									->first();
								echo "Nota Credito B: " . $empresasdocumentosnumeros->numero . "<br>";


						echo "<br>";

				}


		?>

	</div>
</div>




<br><br>

				{{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

				{{ Form::close() }}
			</div>
		</section>
	</div>
</div>









<script src="/js/app.v2.js"></script>

<script>

var jq = jQuery.noConflict();
    jq(document).ready( function(){


    $("#cliente").autocomplete({
		source: "/clientes/search",
      	select: function( event, ui ) {
      		$( '#clientes_id' ).val( ui.item.id );
      }
  });


});


</script>

<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
