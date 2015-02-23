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
			<a class="navbar-brand" href="{{ URL::to('/juegos') }}"> Juegos</a>
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
						<label>Agente</label>
						{{ Form::select( 'agentes_id', Agente::All()->
						lists('agente', 'id'), Input::get('agente'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
					</div>

					<div class="col-xs-3">
						<label>Juego</label>
						{{ Form::select( 'cartons_id', Carton::All()->
						lists('carton', 'id'), Input::get('carton'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
					</div>



						<div class="col-xs-3">
							<label>Sorteo</label>
							{{ Form::text('sorteo', Input::get('sorteo'), array('class' => 'form-control input-lg', 'id' =>'sorteo', 'placeholder' => '')) }}

							@if ($errors->first('sorteo'))
								<span class="label label-warning">{{ $errors->first('sorteo') }}</span>
							@endif

						</div>



					</div>

					<br>
					<div class="row">

						<div class="col-xs-3">
							<label>Valor Juego</label>
							{{ Form::text('valor_juego', Input::get('valor_juego'), array('class' => 'form-control input-lg', 'id' =>'valor_juego', 'name' => 'valor_juego','placeholder' => '')) }}

							@if ($errors->first('valor_juego'))
								<span class="label label-warning">{{ $errors->first('valor_juego') }}</span>
							@endif

						</div>

						<div class="col-xs-3">
							<label>Entregado</label>
							{{ Form::text('entregados', Input::get('entregados'), array('class' => 'form-control input-lg', 'id' =>'entregados', 'name' =>'entregados', 'placeholder' => '')) }}
							@if ($errors->first('entregados'))
								<span class="label label-warning">{{ $errors->first('entregados') }}</span>
							@endif

						</div>


						<div class="col-xs-3">
							<label>Devolucion</label>
							{{ Form::text('devolucion', Input::get('devolucion'), array('class' => 'form-control input-lg ', 'id' =>'devolucion', 'name' =>'devolucion', 'placeholder' => '')) }}
							@if ($errors->first('devolucion'))
								<span class="label label-warning">{{ $errors->first('devolucion') }}</span>
							@endif

						</div>

						<div class="col-xs-3">
						</div>

						<div class="col-xs-3">
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


<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
