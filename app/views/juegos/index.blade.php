@extends('layouts.default')

@section('content')

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<h1>Juegos</h1>
	</div>
</nav>

<a href="{{ URL::to('/juegos/create') }}" class="btn btn-s-md btn-primary">Nueva entrega de juegos</a>

	<?php


		if (count($agentes)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading">{{ $title }}</header>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th>Agente</th>
												<th>Concepto</th>
												<th>A Pagar</th>
												<th>Accion</th>
											</tr>
										</thead>
										<tbody>

											<?php

													foreach ($agentes as $agente)
														{

													// $agente = Agente::find($juego->agentes_id);


													$deuda = 0;

													echo "<tr>";
															echo "<td>" . $agente->agente . "</td>";
															echo "<td>" ;



															$juegos = DB::table('juegos')
																										->where('agentes_id','=', $agente->id)
																										->where('deuda','<', 0)
																										->orderby('id', 'asc')
																										->get();
															if (count($juegos)>0 )  {
																foreach ($juegos as $juego) {

																	$carton = Carton::find($juego->cartons_id);

																	echo "<a href='/juegos/" . $juego->id . "/edit' class='btn btn-xs btn-primary'>" . $carton->carton . "</a> ";
																	echo "$ " . ($juego->deuda * -1) . " ";
																	echo "<a href='/juegos/" . $juego->id . "/saldar' class='btn btn-xs btn-danger'>Saldar</a><br>";



																	$deuda += ($juego->deuda * -1);

																}
															} // endif


															echo "</td>" ;
															echo "<td>" ;

															echo number_format($deuda,2);

															echo "</td>" ;

															echo "<td>" ;


															echo "</td>" ;





													echo "</td>";
													echo "</tr>";


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



									</div>
								</div>

							</footer>
						</section>
		<?php

			}

		?>
<script src="/js/app.v2.js"></script>
@stop
