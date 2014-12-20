@extends('layouts.default')

@section('content')

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<h1>Juegos</h1>
	</div>
</nav>

<a href="{{ URL::to('/juegos/create') }}" class="btn btn-s-md btn-primary">Nueva entrega de juegos</a>

	<?php


		if (count($juegos)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Agente</th>
												<th>Sorteo</th>
												<th>Juego</th>
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

											foreach ($juegos as $juego)
												{

														$agente = Agente::find($juego->agentes_id);
														echo "<tr>";
																echo "<td>" . $juego->sorteo . "</td>";
												        echo "<td>" . $agente->agente . "</td>";
												        echo "<td>" . $juego->valor_juego . "</td>";
																echo "<td>" . $juego->quiniexpress . "</td>";
																echo "<td>" . $juego->entregados . "</td>";
																echo "<td>" . $juego->devolucion . "</td>";
																echo "<td>" . $juego->vendidos . "</td>";
																echo "<td>" . $juego->neto . "</td>";
																echo "<td>" . $juego->a_pagar . "</td>";
																echo "<td>" . $juego->pagado . "</td>";
																echo "<td>" . $juego->deuda . "</td>";
												        echo "<td>" ;

														echo "<a href='/juegos/" . $juego->id . "/edit' class='btn btn-xs btn-primary'>Editar</a> ";

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

									{{ $juegos->links()}}

									</div>
								</div>

							</footer>
						</section>
		<?php

			}

		?>
<script src="/js/app.v2.js"></script>
@stop
