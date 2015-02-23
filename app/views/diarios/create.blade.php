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
			<a class="navbar-brand" href="{{ URL::to('/diarios') }}"> Diarios</a>
		</div>
	</nav>

	<div class="col-sm-12">
		<section class="panel panel-default">
			<header class="panel-heading font-bold">Nueva movimiento en diarios</header>
			<div class="panel-body">
				{{ Form::open(array('route' => 'diarios.store', "autocomplete"=>"off"
				, 'class' => 'panel-body wrapper-lg')) }}


				<div class="row">
					<div class="col-xs-3">
						<label>Cuenta</label>
						{{ Form::select( 'cuentas_id', Cuenta::orderby('cuenta', 'asc')->
						lists('cuenta', 'id'), Input::get('cuenta'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
					</div>

					<div class="col-xs-3">
						<label>Importe</label>
						{{ Form::text('importe', Input::get('importe'), array('class' => 'form-control input-lg', 'id' =>'importe', 'name' => 'importe','placeholder' => '')) }}

						@if ($errors->first('importe'))
							<span class="label label-warning">{{ $errors->first('importe') }}</span>
						@endif

					</div>

						<div class="col-xs-3">
							<label>Tipo</label>
								{{ Form::select('tipo', array('debe' => 'debe', 'ingreso' => 'haber'), 'debe', array('class' => 'form-control input-lg', 'id' =>'tipo')) }}
						</div>

						<div class="col-xs-3">

						</div>


					</div>

					<br>
					<div class="row">


						<div class="col-xs-9">
							<label>Descripcion</label>
							{{ Form::text('descripcion', Input::get('descripcion'), array('class' => 'form-control input-lg', 'id' =>'descripcion', 'name' =>'descripcion', 'placeholder' => '')) }}
							@if ($errors->first('entregados'))
								<span class="label label-warning">{{ $errors->first('descripcion') }}</span>
							@endif

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
