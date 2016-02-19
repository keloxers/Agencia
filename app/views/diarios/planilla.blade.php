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
			<header class="panel-heading font-bold">{{ $title }}</header>
			<div class="panel-body">
				{{ Form::open(array('route' => 'diarios.planillashow', "autocomplete"=>"off"
				, 'class' => 'panel-body wrapper-lg')) }}


				<div class="row">
					<div class="col-xs-4">

						<div class="form-group">
							<label>Fecha</label>
							{{ Form::text('fecha', '', array('class' => 'datepicker-input form-control input-lg', 'id' =>'fecha', 'placeholder' => 'Fecha', 'data-date-format' => 'dd-mm-yyyy')) }}
						</div>

						<?php if ($errors->first('fecha')) { ?>
							<span class="badge bg-danger">{{ $errors->first('fecha') }}</span>
						<?php } ?>


					</div>


					</div>


					<br>

				<div class="row">
					{{ Form::submit('Mostrar', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>



			</div>
		</section>
	</div>
</div>









<script src="/js/app.v2.js"></script>


<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
