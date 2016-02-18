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
			<header class="panel-heading font-bold">Cuentas</header>
			<div class="panel-body">


				<?php


					if (count($cuentas)>0 )  {


			?>
										<section class="panel panel-default">
											<header class="panel-heading"></header>

											<div class="table-responsive">
												<table class="table table-striped b-t b-light text-sm">
													<thead>
														<tr>
															<th class='text-left'>Cuenta</th>
														</tr>
													</thead>
													<tbody>

															<?php

														foreach ($cuentas as $cuenta)
															{

																				echo "<tr>";
																						echo "<td>";
																							echo "<a href='/cuentacorriente/" . $cuenta->id . "'>";
																							echo $cuenta->cuenta;
																							echo "</a> ";
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

												{{ $cuentas->links()}}

												</div>
											</div>

										</footer>
									</section>
					<?php

						}

					?>









			</div>
		</section>
	</div>
</div>









<script src="/js/app.v2.js"></script>


<script src="/js/datepicker/bootstrap-datepicker.js" cache="false"></script>

@stop
