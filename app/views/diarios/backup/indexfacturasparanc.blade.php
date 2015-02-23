@extends('layouts.default')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/datepicker/datepicker.css" type="text/css" cache="false" />


<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<div class="navbar-brand">{{ $cliente->cliente}}</div>
	</div>
</nav>


	<?php


		if (count($ventasmovimientos)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>


									{{ Form::open(array('route' => 'ventasmovimientos.nccreate', "autocomplete"=>"off", 'class' => 'panel-body wrapper-lg')) }}


							<div class="checkbox">
								<label>
									<input type="checkbox" name="sinseleccion" id="sinseleccion" value="si">
									No asociado a alguna factura
								</label>
							</div>

							{{ Form::hidden('clientes_id' , $cliente->id, array('id' =>$cliente->id)) }}
							{{ Form::hidden('empresas_id' , $empresas_id, array('id' =>$empresas_id)) }}
							{{ Form::hidden('fecha' , $fecha, array('fecha' =>$fecha)) }}

							<br>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Cliente</th>
												<th>Tipo Documento</th>
												<th>Numero Documento</th>
												<th>Seleccion</th>
											</tr>
										</thead>
										<tbody>

												<?php


											foreach ($ventasmovimientos as $ventasmovimiento)
												{

														$cliente = Cliente::find($ventasmovimiento->clientes_id);
														$tiposdocumento = Tiposdocumento::find($ventasmovimiento->tiposdocumentos_id);

														echo "<tr>";
												        echo "<td>" . $ventasmovimiento->fecha . "</td>";
												        echo "<td>" . $cliente->cliente . "</td>";
												        echo "<td>" . $tiposdocumento->tiposdocumento . "</td>";
												        echo "<td>" . str_pad($ventasmovimiento->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
												        echo "<td>" ;
																echo "

																<div class='radio'>
																<input type='radio' name='ventasmovimientos_id' id='ventasmovimientos_id' value='" . $ventasmovimiento->id . "'>
																</div>

																";


														print "</td>";
														print "</tr>";


												}


											?>


									</tbody>
								</table>
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

						{{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

						{{ Form::close() }}

						</section>
		<?php

	} else {
		echo "Nada que mostrar";
	}

		?>

@stop
