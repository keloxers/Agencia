@extends('layouts.default')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="/js/jquery.number.min.js"></script>

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('/ventasmovimientos/notacredito') }}">Nota de Creditos</a>
	</div>

</nav>

<section class="panel panel-default">
	<header class="panel-heading font-bold">Editar</header>
	<div class="panel-body">


		{{ Form::open(array('route' => 'ventasmovimientoscuerpos.store', 'class' => 'panel-body wrapper-lg')) }}
		{{ Form::hidden('ventasmovimientos_id' , $ventasmovimiento->id, array('id' =>'ventasmovimientos_id')) }}

		<?php
				$tiposdocumento = Tiposdocumento::find($ventasmovimiento->tiposdocumentos_id);
				$cliente = Cliente::find($ventasmovimiento->clientes_id);

		?>



		<div class="row">
			<div class="col-md-4">

				<div class="form-group">
					<label>Tipo y Numero de Documentos</label>

					<div class="form-control input-lg">
						{{ $tiposdocumento->tiposdocumento }} -  {{ str_pad($ventasmovimiento->numero_comprobante, 12, '0', STR_PAD_LEFT) }}
					</div>

				</div>
			</div>
			<div class="col-md-8">

				<div class="form-group">
					<label>Cliente</label>

					<div class="form-control input-lg">
						{{ $cliente->cliente }}
					</div>

				</div>
			</div>
		</div>


<div class="row">
  <div class="col-md-1">Cantidad</div>
  <div class="col-md-5">Articulo</div>
  <div class="col-md-2">P. unitario</div>
  <div class="col-md-2">Bonificacion</div>
  <div class="col-md-2">P. Total</div>
</div>


<div class="row">
  <div class="col-md-1">

	{{ Form::text('cantidad', '1', array('class' => 'form-control input-lg', 'id' =>'cantidad', 'placeholder' => '')) }}

  </div>
  <div class="col-md-5">
	{{ Form::text('articulo', '', array('class' => 'form-control input-lg', 'id' =>'articulo', 'placeholder' => '')) }}
	{{ Form::hidden('articulos_id' , Input::old('articulos_id'), array('id' =>'articulos_id')) }}
  </div>
  <div class="col-md-2">
	{{ Form::text('precio_unitario', '0.00', array('class' => 'form-control input-lg', 'id' =>'precio_unitario', 'placeholder' => '')) }}
	{{ Form::hidden('iva' , Input::old('iva'), array('id' =>'iva')) }}
  </div>
  <div class="col-md-2">
  	{{ Form::text('bonificacion', '0.00', array('class' => 'form-control input-lg', 'id' =>'bonificacion', 'placeholder' => '')) }}
  </div>
  <div class="col-md-2">
  	{{ Form::text('precio_total', '0.00', array('class' => 'form-control input-lg', 'id' =>'precio_total', 'placeholder' => '')) }}
  </div>
</div>
<br>
<div class="row">
	<div class="col-md-11">Descripcion:
		{{ Form::text('descripcion', '', array('class' => 'form-control input-lg', 'id' =>'descripcion', 'placeholder' => '')) }}
	</div>
<div class="col-md-1">
		{{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

</div>
</div>


	{{ Form::close() }}

	{{ View::make('ventasmovimientoscuerpos.index', array('title' => $title, 'id' => $ventasmovimiento->id)) }}

	</div>

</section>

<a href='/ventasmovimientos/{{ $ventasmovimiento->id }}/cerrar' class='btn btn-primary'>Cerrar</a>

<script src="/js/app.v2.js"></script>

<script>

var jq = jQuery.noConflict();
    jq(document).ready( function(){


	$('#cantidad').number( true, 0 );
	$('#precio_unitario').number( true, 2, '.','' );
	$('#bonificacion').number( true, 2, '.','' );
	$('#precio_total').number( true, 2, '.','' );




    $("#articulo").autocomplete({
		source: "/articulos/search",
      	select: function( event, ui ) {
      		$( '#articulos_id' ).val( ui.item.id );
      		$( '#precio_unitario' ).val( ui.item.precio );
			$( '#iva' ).val( ui.item.iva );
			calcular_precio_publico();

      		}

  		});

	$("#bonificacion").blur(function(){
		calcular_precio_publico();

	});

	function calcular_precio_publico() {
      		var precio_total =  parseFloat($('#cantidad').val()) * parseFloat($('#precio_unitario').val());
      		precio_total = precio_total - parseFloat($('#bonificacion').val());

      		$( '#precio_total' ).val( precio_total );
}


});


</script>

@stop
