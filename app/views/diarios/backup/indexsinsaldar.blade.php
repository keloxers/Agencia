@extends('layouts.default')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/datepicker/datepicker.css" type="text/css" cache="false" />

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('/ventasmovimientos') }}">Movimientos sin saldar</a>
	</div>

</nav>


	<?php


		if (count($ventasmovimientos)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>

								<div class="table-responsive">

										{{ Form::open(array('route' => 'ventasmovimientos.crearrecibos', "autocomplete"=>"off", 'class' => 'panel-body wrapper-lg')) }}

										{{ Form::hidden('id', $id) }}



									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Id</th>
												<th>Fecha</th>
												<th>Cliente</th>
												<th>Tipo Documento</th>
												<th>Numero Documento</th>
												<th>Importe total</th>
												<th>Saldo movimiento</th>
												<th>Accion</th>
											</tr>
										</thead>
										<tbody>


												<?php

											foreach ($ventasmovimientos as $ventasmovimiento)
												{

														$cliente = Cliente::find($ventasmovimiento->clientes_id);
														$tiposdocumento = Tiposdocumento::find($ventasmovimiento->tiposdocumentos_id);


														echo "<tr>";
												        echo "<td>" . $ventasmovimiento->id . "</td>";
												        echo "<td>" . $ventasmovimiento->fecha . "</td>";
												        echo "<td>" . $cliente->cliente . "</td>";
												        echo "<td>" . $tiposdocumento->tiposdocumento . "</td>";
												        echo "<td align='right'>" . str_pad($ventasmovimiento->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
												        echo "<td align='right'>" . $ventasmovimiento->importe_total . "</td>";
												        echo "<td align='right'>";

																$saldomovimiento = $ventasmovimiento->saldo_movimiento;
																if ($tiposdocumento->id==6 or $tiposdocumento->id==9 or $tiposdocumento->id==11) {
												        		$saldomovimiento *= (-1);
																}

																echo number_format($saldomovimiento,2);

												        echo "</td>";
												        echo "<td>" ;

														?>

<!-- 														{{ Form::checkbox($ventasmovimiento->id, $ventasmovimiento->saldo_movimiento, false) }}
 -->

																<input class="checkbox" type='checkbox' name='ids[{{$ventasmovimiento->id}}]' id='{{$ventasmovimiento->id}}' value='{{$saldomovimiento}}'>


<!-- 														<input class="checkbox" type="checkbox" value="{{ $ventasmovimiento->saldo_movimiento }}" name="{{$ventasmovimiento->id}}" />
 -->

														<?php

														print "</td>";
														print "</tr>";


												}


											?>



									</tbody>
								</table>


<div class="row">
<div class="col-xs-3">
<label>Empresa</label>
	{{ Form::select( 'empresas_id', Empresa::All()->
				lists('empresa', 'id'), Input::get('empresa'), array( "placeholder" => "", 'class' => 'form-control input-lg')) }}
</div>
</div>

<br>

<div class="row">
	<div class="col-xs-3">
	<label>Fecha</label>
		{{ Form::text('fecha', '', array('class' => 'datepicker-input form-control input-lg', 'id' =>'fecha', 'placeholder' => 'Fecha', 'data-date-format' => 'dd-mm-yyyy')) }}

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

<br>


<div class="row">
	<label>Numero Recibo</label><br>
	<div class="col-xs-3">
		{{ Form::text('numero_comprobante', '', array('class' => 'form-control input-lg', 'id' =>'numero_comprobante', 'placeholder' => 'numero comprobante')) }}

<br> <?php
	if ($errors->first('numero_comprobante')) {
			?>
		<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-ban-circle"></i> <strong>Ups... error!</strong>
		<div class="alert-link">{{ $errors->first('numero_comprobante') }}</div>
	</div>
<?php } ?>

	</div>
</div>
<br>



								<div class="row">
									<br>
									<div> <span id="span"></span>
 										Total seleccion: <span id="usertotal"> </span>
									</div>
									<br>
								<label>Importe Recibo</label><br>
								<div class="col-xs-3">
								{{ Form::text('importe_recibo', '0.00', array('class' => 'form-control input-lg', 'id' =>'importe_recibo', 'placeholder' => 'Importe recibo')) }}
								</div>
								</div>

								<br>

								<div class="row">
								{{ Form::submit('Crear recibo', array('class' => 'btn btn-primary')) }}
								</div>
								{{ Form::close() }}

							</div>
							<footer class="panel-footer">

								<div class="row">
									<div class="col-sm-4 hidden-xs">
										<!-- <select class="input-sm form-control input-s-sm inline">
											<option value="0">Bulk action</option>
											<option value="1">Delete selected</option>
											<option value="2">Bulk edit</option>
											<option value="3">Export</option>
										</select> -->
									</div>
									<div class="col-sm-4 text-center">
										<!-- <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small> -->
									</div>
									<div class="col-sm-4 text-right text-center-xs">

									{{ $ventasmovimientos->links()}}

									</div>
								</div>

							</footer>
						</section>
		<?php

			}

		?>

<script src="/js/app.v2.js"></script>

<script>

var jq = jQuery.noConflict();
    jq(document).ready( function(){


		function displayVals() {
		      calcUsage();
		      var singleValues = 0; //$("#more").val();

		}
		var $cbs = $('.checkbox');
		function calcUsage() {
		    var total = 0; //$("#more").val();
		    $cbs.each(function() {
		        if ($(this).is(":checked"))
		            total = parseFloat(total) + parseFloat($(this).val());
		    });
		    $("#usertotal").text(total.toFixed(2));
		    $("#importe_recibo").val(total.toFixed(2));
		}

		    $("select").change(displayVals);
		    displayVals();
		//For  checkboxes

		$cbs.click(function() {
		    calcUsage();
		});



});

</script>


<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
