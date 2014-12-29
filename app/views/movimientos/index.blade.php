@extends('layouts.default')

@section('content')

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<h1>movimientos</h1>
	</div>
</nav>

<a href="{{ URL::to('/movimientos/create') }}" class="btn btn-s-md btn-primary">Nueva entrega de movimientos</a>

	<?php


		if (count($movimientos)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Agente</th>
												<th>movimiento</th>
												<th>Sorteo</th>
												<th>Valor</th>
												<th>Entregado</th>
												<th>Vendido</th>
												<th>A pagar</th>
												<th>Pagado</th>
												<th>Deuda</th>
												<th>Accion</th>
											</tr>
										</thead>
										<tbody>

												<?php

											foreach ($movimientos as $movimiento)
												{

														$agente = Agente::find($movimiento->agentes_id);
														$carton = Carton::find($movimiento->cartons_id);

														echo "<tr>";
												        echo "<td>" . $agente->agente . "</td>";
																echo "<td>" . $carton->carton . "</td>";
																echo "<td>" . $movimiento->sorteo . "</td>";
												        echo "<td>" . $movimiento->valor_movimiento . "</td>";
																echo "<td>" . $movimiento->entregados . "</td>";
																echo "<td>" . $movimiento->vendidos . "</td>";
																echo "<td>" . $movimiento->a_pagar . "</td>";
																echo "<td>" . $movimiento->pagado . "</td>";
																echo "<td>" . $movimiento->deuda . "</td>";
												        echo "<td>" ;


														echo "<a href='/movimientos/" . $movimiento->id . "/edit' class='btn btn-xs btn-primary'>Editar</a> ";

														if($movimiento->deuda < 0) {
															echo "<a href='/movimientos/" . $movimiento->id . "/saldar' class='btn btn-xs btn-danger'>Saldar</a> ";
														}

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

									{{ $movimientos->links()}}

									</div>
								</div>

							</footer>
						</section>
		<?php

			}

		?>
<script src="/js/app.v2.js"></script>
@stop
