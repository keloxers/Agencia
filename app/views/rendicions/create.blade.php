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
			<a class="navbar-brand" href="{{ URL::to('/rendicions') }}">Rendiciones</a>
		</div>
	</nav>

	<div class="col-sm-12">
		<section class="panel panel-default">
			<header class="panel-heading font-bold">Nueva rendicion</header>
			<div class="panel-body">
				{{ Form::open(array('route' => 'rendicions.store', "autocomplete"=>"off"
				, 'class' => 'panel-body wrapper-lg')) }}


				<div class="row">
					<div class="col-xs-4">
						<label>Maquina Nro</label>
						{{ Form::text('maquina', '', array('class' => 'form-control input-lg ', 'id' =>'maquina', 'name' =>'maquina', 'placeholder' => '')) }}
					</div>

						<div class="col-xs-4">
							<label>Agente</label>
							{{ Form::select( 'agentes_id', Agente::All()->
							lists('agente', 'id'), Input::get('agente'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
						</div>

						<div class="col-xs-4">
							<label>Sorteo</label>
							{{ Form::text('sorteo', '', array('class' => 'form-control input-lg', 'id' =>'sorteo', 'placeholder' => '')) }}
						</div>


					</div>

					<br>
					<div class="row">


						<div class="col-xs-3">
							<label>Quiniela</label>
							{{ Form::text('quiniela', '', array('class' => 'form-control input-lg', 'id' =>'quiniela', 'name' =>'quiniela', 'placeholder' => '')) }}
						</div>

						<div class="col-xs-3">
							<label>Quini Expres</label>
							{{ Form::text('quiniexpress', '', array('class' => 'form-control input-lg', 'id' =>'quiniexpress', 'name' =>'quiniexpress', 'placeholder' => '')) }}

						</div>

						<div class="col-xs-3">
							<label>Juegos</label>
							{{ Form::text('juegos', '', array('class' => 'form-control input-lg', 'id' =>'juegos', 'name' =>'juegos', 'placeholder' => '')) }}
						</div>

						<div class="col-xs-3">
							<label>Premios</label>
							{{ Form::text('premios', '', array('class' => 'form-control input-lg', 'id' =>'premios', 'name' =>'premios', 'placeholder' => '')) }}
						</div>

					</div>

					<br>
					<div class="row">


						<div class="col-xs-3">
							<label>a Pagar Quiniela</label>
							{{ Form::text('quiniela_pagar', '', array('class' => 'form-control input-lg ', 'id' =>'quiniela_pagar', 'name' =>'quiniela_pagar', 'placeholder' => '', 'disabled' => 'disabled',)) }}
						</div>

						<div class="col-xs-3">
							<label>a Pagar Quini Expres</label>
							{{ Form::text('quiniexpress_pagar', '', array('class' => 'form-control input-lg', 'id' =>'quiniexpress_pagar', 'name' =>'quiniexpress_pagar', 'placeholder' => '','disabled' => 'disabled',)) }}
						</div>

						<div class="col-xs-3">
							<label>a Pagar Juegos</label>
							{{ Form::text('juegos_pagar', '', array('class' => 'form-control input-lg', 'id' =>'juegos_pagar', 'name' =>'juegos_pagar', 'placeholder' => '','disabled' => 'disabled',)) }}
						</div>

						<div class="col-xs-3">
							<label>Neto</label>
							{{ Form::text('neto_pagar', '', array('class' => 'form-control input-lg', 'id' =>'neto_pagar', 'name' =>'neto_pagar', 'placeholder' => '','disabled' => 'disabled',)) }}
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


	$("#quiniela").blur(function(){
		$('#quiniela').val(accounting.formatMoney($('#quiniela').val()));
		calcular_total();
	});



	$("#quiniexpress").blur(function(){
		$('#quiniexpress').val(accounting.formatMoney($('#quiniexpress').val()));
		calcular_total();
	});


	$("#juegos").blur(function(){
		$('#juegos').val(accounting.formatMoney($('#juegos').val()));
		calcular_total();
	});


	$("#premios").blur(function(){
		$('#premios').val(accounting.formatMoney($('#premios').val()));
		calcular_total();
		$( '#pagado' ).val( accounting.formatMoney(parseFloat($('#neto_pagar').val())));
	});

	$("#pagado").blur(function(){
		$('#pagado').val(accounting.formatMoney($('#pagado').val()));
		calcular_total();

	});


	function calcular_total() {

		$('#quiniela_pagar').val(accounting.formatMoney(parseFloat($('#quiniela').val() * 0.85)));
		$('#quiniexpress_pagar').val(accounting.formatMoney(parseFloat($('#quiniexpress').val() * 0.92)));
		$('#juegos_pagar').val(accounting.formatMoney(parseFloat($('#juegos').val() * 0.90)));


		var total =  parseFloat($('#quiniela_pagar').val())
								+ parseFloat($('#quiniexpress_pagar').val())
								+ parseFloat($('#juegos_pagar').val())
								- parseFloat($('#premios').val());

		var deuda = accounting.formatMoney(parseFloat(parseFloat($('#pagado').val()) - total));

		$( '#neto_pagar' ).val( accounting.formatMoney(total));
		$( '#deuda' ).val( accounting.formatMoney(deuda));



	};



});


</script>

<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
