@extends('layouts.default')

@section('content')

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<div class="navbar-brand">{{ $title }}</div>
		<a class="navbar-brand" href="{{ URL::to('/ventasmovimientos/notacredito/create') }}">Crear</a>
	</div>
</nav>


	<?php


		if (count($ventasmovimientos)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Cliente</th>
												<th>Tipo Documento</th>
												<th>Numero Documento</th>
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
																echo "<td>" . $ventasmovimiento->fecha . "</td>";
																echo "<td>" . $cliente->cliente . "</td>";
																echo "<td>" . $tiposdocumento->tiposdocumento . "</td>";
																echo "<td>" . str_pad($ventasmovimiento->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
																echo "<td>" ;

														echo "<a href='/ventasmovimientos/" . $ventasmovimiento->id . "/cuerpo' class='btn btn-xs btn-primary'>Editar</a> ";

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
						</section>
		<?php

	} else {
		echo "Nada que mostrar";
	}

		?>
<script src="/js/app.v2.js"></script>
@stop
