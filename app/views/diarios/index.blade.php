@extends('layouts.default')

@section('content')

<?php
	$date = Carbon::now();
	$date = $date->format('d-m-Y');
 ?>

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<h1> Diario</h1>
	</div>
</nav>

<a href="{{ URL::to('/diarios/create') }}" class="btn btn-s-md btn-primary">Agregar movimiento</a>

	<?php


		if (count($diarios)>0 )  {


?>
							<section class="panel panel-default">
								<header class="panel-heading"></header>

								<div class="table-responsive">
									<table class="table table-striped b-t b-light text-sm">
										<thead>
											<tr>
												<th class='text-left'>Fecha</th>
												<th class='text-left'>Cuenta</th>
												<th class='text-left'>Descripcion</th>
												<th class='text-center'>Debe</th>
												<th class='text-center'>Haber</th>
												<th class='text-center'>Accion</th>
											</tr>
										</thead>
										<tbody>

												<?php

												$primero = true;
												$haber = 0;
												$debe = 0;

											foreach ($diarios as $diario)
												{

													// if($primero) {
													// 	$ultima_fecha = $diario->created_at;
													// 	$primero = false;
													// }
													//
													// if ($ultima_fecha <> $diario->created_at ){
													// 	exit;
													// }

														$cuenta = Cuenta::find($diario->cuentas_id);

														if ($cuenta->mostrar_diario){

																	echo "<tr>";
																			echo "<td>";


																				$fecha = new Carbon($diario->created_at);
																				echo $fecha->format('d-m-Y');


																			echo "</td>";
																			echo "<td>" . $cuenta->cuenta . "</td>";
																			echo "<td>" . $diario->descripcion . "</td>";
																			echo "<td class='text-right'>";
																			if ($diario->tipo=="debe") {
																				echo number_format($diario->importe,2);
																				$debe += $diario->importe;
																			}
																			echo "</td>";
																			echo "<td class='text-right'>";
																			if ($diario->tipo=="haber") {
																				echo number_format($diario->importe,2);
																				$haber += $diario->importe;
																			}
																			echo "</td>";

															        echo "<td class='text-center'>" ;
																					echo "<a href='/diarios/" . $diario->id . "/edit' class='btn btn-xs btn-primary'>Editar</a> ";
																			echo "</td>";
																	echo "</tr>";
														}

												}

												echo "<tr>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td></td>";
												echo "<td class='text-right'>" . number_format($debe,2) . "</td>";
												echo "<td class='text-right'>" . number_format($haber,2).  "</td>";

												echo "<td></td>";
												print "</tr>";


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

									{{ $diarios->links()}}

									</div>
								</div>

							</footer>
						</section>
		<?php

			}

		?>
<script src="/js/app.v2.js"></script>
@stop
