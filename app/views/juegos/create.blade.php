@extends('layouts.default')



@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/datepicker/datepicker.css" type="text/css" cache="false" />
<!-- <script src="/js/jquery.number.min.js"></script> -->
<script src="/js/accounting.min.js"></script>



<div class="row">

	<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ URL::to('/juegos') }}">Juegos</a>
		</div>
	</nav>

	<div class="col-sm-12">
		<section class="panel panel-default">
			<header class="panel-heading font-bold">Nueva entrega de Juegos</header>
			<div class="panel-body">
				{{ Form::open(array('route' => 'juegos.store', "autocomplete"=>"off"
				, 'class' => 'panel-body wrapper-lg')) }}


				<div class="row">
					<div class="col-xs-3">
						<label>Juego</label>
						{{ Form::select( 'cartons_id', Carton::All()->
						lists('carton', 'id'), Input::get('carton'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
					</div>

					<div class="col-xs-3">
						<label>Valor Juego</label>
						{{ Form::text('valor_juego', '', array('class' => 'form-control input-lg', 'id' =>'valor_juego', 'name' => 'valor_juego','placeholder' => '')) }}
					</div>

						<div class="col-xs-3">
							<label>Agente</label>
							{{ Form::select( 'agentes_id', Agente::All()->
							lists('agente', 'id'), Input::get('agente'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
						</div>

						<div class="col-xs-3">
							<label>Sorteo</label>
							{{ Form::text('sorteo', '', array('class' => 'form-control input-lg', 'id' =>'sorteo', 'placeholder' => '')) }}
						</div>


					</div>

					<br>
					<div class="row">


						<div class="col-xs-3">
							<label>Entregado</label>
							{{ Form::text('entregados', '', array('class' => 'form-control input-lg', 'id' =>'entregados', 'name' =>'entregados', 'placeholder' => '')) }}
						</div>

						<div class="col-xs-3">
							<label>Devolucion</label>
							{{ Form::text('devolucion', '', array('class' => 'form-control input-lg', 'id' =>'devolucion', 'name' =>'devolucion', 'placeholder' => '')) }}

						</div>

						<div class="col-xs-3">
							<label>Vendidos</label>
							{{ Form::text('vendidos', '', array('class' => 'form-control input-lg', 'id' =>'vendidos', 'name' =>'vendidos', 'placeholder' => '')) }}
						</div>

						<div class="col-xs-3">
							<label>A Pagar</label>
							{{ Form::text('a_pagar', '', array('class' => 'form-control input-lg', 'id' =>'a_pagar', 'name' =>'a_pagar', 'placeholder' => '')) }}
						</div>

					</div>

					<br>
					<div class="row">


						<div class="col-xs-3">
							<label>Pagar Efectivo</label>
							{{ Form::text('pagado', '', array('class' => 'form-control input-lg ', 'id' =>'pagado', 'name' =>'pagado', 'placeholder' => '')) }}
						</div>


					</div>

					<br>
					<div class="row">


						<div class="col-xs-3">
							<label>Deuda</label>
							{{ Form::text('deuda', '', array('class' => 'form-control input-lg ', 'id' =>'deuda', 'name' =>'deuda', 'placeholder' => '', 'disabled' => 'disabled',)) }}
						</div>


					</div>


					<br><br><br>

					<br><br><br>

				<div class="row">
					{{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>



			</div>
		</section>
	</div>
</div>









<script src="/js/app.v2.js"></script>

<script>

var jq = jQuery.noConflict();
jq(document).ready( function(){


	// $('#quiniela').number( true, 0 );
	// $('#quiniexpress').number( true, 2, '.','' );
	// $('#juegos').number( true, 2, '.','' );
	// $('#premios').number( true, 2, '.','' );



	accounting.settings = {
		currency: {
			symbol : "",   // default currency symbol is '$'
			format: "%s%v", // controls output: %s = symbol, %v = value/number (can be object: see below)
			decimal : ".",  // decimal point separator
			thousand: "",  // thousands separator
			precision : 2   // decimal places
		},
		number: {
			precision : 0,  // default precision on numbers is 0
			thousand: ",",
			decimal : "."
		}
	}


	$("#valor_juego").blur(function(){
		$('#valor_juego').val(accounting.formatMoney($('#valor_juego').val()));
		calcular_total();
	});



	$("#entregado").blur(function(){
		$('#entregado').val(accounting.number($('#entregado').val()));
		calcular_total();
	});



	$("#devolucion").blur(function(){
		$('#devolucion').val(accounting.number($('#devolucion').val()));
		calcular_total();
	});


	$("#vendidos").blur(function(){
		$('#vendidos').val(accounting.number($('#vendidos').val()));
		calcular_total();
	});



	$("#a_pagar").blur(function(){
		$('#a_pagar').val(accounting.formatMoney($('#a_pagar').val()));
		calcular_total();
	});


	$("#pagado").blur(function(){
		$('#pagado').val(accounting.formatMoney($('#pagado').val()));
		calcular_total();

	});


	function calcular_total() {


		// $('#juegos_pagar').val(accounting.formatMoney(parseFloat($('#juegos').val() * 0.90)));


		var vendidos =  (parseFloat($('#entregados').val())
								- parseFloat($('#devolucion').val()) );


		// alert(vendidos);


		var total =  vendidos
								* parseFloat($('#valor_juego').val())
								* 0.90;

		// $( '#vendidos' ).val( accounting.number(vendidos));

		$( '#a_pagar' ).val( accounting.formatMoney(total));

		var deuda = accounting.formatMoney(parseFloat(parseFloat($('#pagado').val()) - total));


		$( '#deuda' ).val( accounting.formatMoney(deuda));



	};



});


</script>

<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
