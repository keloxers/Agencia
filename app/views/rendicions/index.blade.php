@extends('layouts.default')

@section('content')

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<h1>Rendiciones</h1>
	</div>
</nav>

<a href="{{ URL::to('/rendicions/create') }}" class="btn btn-s-md btn-primary">Nueva rendición</a>

	<?php


		if (count($rendicions)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Maquina</th>
												<th>Sorteo</th>
												<th>Agente</th>
												<th>Quiniela</th>
												<th>Q Express</th>
												<th>Juegos</th>
												<th>Premios</th>
												<th>A pagar</th>
												<th>Pagado</th>
												<th>Deuda</th>
												<th>Accion</th>
											</tr>
										</thead>
										<tbody>

												<?php

											foreach ($rendicions as $rendicion)
												{

														$agente = Agente::find($rendicion->agentes_id);

														echo "<tr>";
																echo "<td>" . $rendicion->maquina . "</td>";
																echo "<td>" . $rendicion->sorteo . "</td>";
												        echo "<td>" . $agente->agente . "</td>";
												        echo "<td>" . $rendicion->quiniela . "</td>";
																echo "<td>" . $rendicion->quiniexpress . "</td>";
																echo "<td>" . $rendicion->juegos . "</td>";
																echo "<td>" . $rendicion->premios . "</td>";
																echo "<td>" . $rendicion->neto_pagar . "</td>";
																echo "<td>" . $rendicion->pagado . "</td>";
																echo "<td>" . $rendicion->deuda . "</td>";
												        echo "<td>" ;

														echo "<a href='/rendicions/" . $rendicion->id . "/edit' class='btn btn-xs btn-primary'>Editar</a> ";

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

									{{ $rendicions->links()}}

									</div>
								</div>

							</footer>
						</section>
		<?php

			}

		?>
<script src="/js/app.v2.js"></script>
@stop
