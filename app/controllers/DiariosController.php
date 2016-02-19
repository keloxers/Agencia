<?php

class DiariosController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

				$hoy = Carbon::now();
				$hoy = $hoy->format('Y-m-d');
				// echo $hoy;
				// die;

        $diarios = DB::table('diarios')
															->whereRaw("DATE(created_at) = '$hoy'")
															->orderby('id', 'asc')
															->paginate(50);
        $title = "diarios";
        return View::make('diarios.index', array('title' => $title, 'diarios' => $diarios));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('diarios.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		// echo Input::get('vendidos');
		// $input = Input::all();
		// var_dump($input);
		// die;

		$rules = [
			'importe' => 'numeric|required',
			'cuentas_id' => 'exists:cuentas,id'
		];

		if (! Diario::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Diario::$errors);

		}

		$diario = new Diario;

		$diario->cuentas_id = Input::get('cuentas_id');
		$diario->tipo = Input::get('tipo');
		$diario->importe = Input::get('importe');
		$diario->descripcion =  Input::get('descripcion');

		$diario->save();

		return Redirect::to('/diarios');

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$diario = Diario::find($id);
		$title = "Editar diario";

        return View::make('diarios.edit', array('title' => $title, 'diario' => $diario));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{


		$rules = [
			'importe' => 'numeric|required',
			'cuentas_id' => 'exists:cuentas,id'
		];

		if (! Diario::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Diario::$errors);

		}


		$diario = Diario::find($id);

		$diario->cuentas_id = Input::get('cuentas_id');
		$diario->tipo = Input::get('tipo');
		$diario->importe = Input::get('importe');
		$diario->descripcion =  Input::get('descripcion');

		$diario->save();

		return Redirect::to('/diarios');
	}



public function saldar($id)
{
	$diario = diario::find($id);
	$a_pagar = $diario->a_pagar;
	$diario->pagado = $a_pagar;
	$diario->deuda = 0;
	$diario->save();

	return Redirect::to('/diarios');
}


	public function cuerpo($id)
	{

        $ventasdiario = Ventasdiario::find($id);

        $title = "Cuerpo diarios";
        return View::make('ventasdiarios.show', array('title' => $title, 'ventasdiario' => $ventasdiario));


	}


	public function cerrar($id)
	{

		$ventasdiario = Ventasdiario::find($id);


		$total =  DB::table('ventasdiarioscuerpos')->where('ventasdiarios_id', $id)->sum('precio_total');
		$bonificacion =  DB::table('ventasdiarioscuerpos')->where('ventasdiarios_id', $id)->sum('bonificacion');

		$importe_gravado = DB::table('ventasdiarioscuerpos')->where('ventasdiarios_id', $id)->sum('importe_gravado');
		$importe_no_gravado = DB::table('ventasdiarioscuerpos')->where('ventasdiarios_id', $id)->sum('importe_no_gravado');


		$importe_iva = DB::table('ventasdiarioscuerpos')->where('ventasdiarios_id', $id)->sum('importe_iva');

		$importe_otros_impuestos = DB::table('ventasdiarioscuerpos')->where('ventasdiarios_id', $id)->sum('importes_otros_impuestos');



		if ($ventasdiario->condicionesventas_id == 1 ) {
			$contado = true;
			$ventasdiario->estado = 'cerrada';
			$ventasdiario->saldo_diario = 0;
		} else {
			$contado = false;
			$ventasdiario->estado = 'pendiente';
			$ventasdiario->saldo_diario = $total;
		}

		// es una nota de credito
		if ($ventasdiario->tiposdocumentos_id == 6) {
			$contado = false;
			$ventasdiario->estado = 'pendiente';
			$ventasdiario->saldo_diario = $total;
		}


		$ventasdiario->importe_total = $total;


		$ventasdiario->importe_gravado = $importe_gravado;
		$ventasdiario->importe_no_gravado = $importe_no_gravado;
		$ventasdiario->importe_iva = $importe_iva;
		$ventasdiario->importe_otros_impuestos = $importe_otros_impuestos;
		$ventasdiario->porcentaje_bonificacion = 0;
		$ventasdiario->importe_bonificacion = $bonificacion;

		$ventasdiario->save();

		return Redirect::to('/ventasdiarios');

	}


	public function recibos()
	{

        $title = "Recibos";
        return View::make('ventasdiarios.recibo');
	}



	public function diariossinsaldar()
	{

			$rules = [
				'clientes_id' => 'exists:clientes,id',
			];

			if (! Ventasdiario::isValid(Input::all(),$rules)) {
				return Redirect::back()->withInput()->withErrors( Ventasdiario::$errors);
			}

		$id = Input::get('clientes_id');


        $ventasdiarios =  DB::table('ventasdiarios')
        ->where('clientes_id', $id)
        ->where('saldo_diario', '>', 0)
				->whereIn('tiposdocumentos_id', array(1,2,3,4,6,7,9,10,11))
				->paginate(20);


        $title = "diarios sin saldar";
        return View::make('ventasdiarios.indexsinsaldar', array('title' => $title, 'ventasdiarios' => $ventasdiarios, 'id' => $id));

	}



	public function diariossinsaldarseleccion()
	{




				$id = Input::get('clientes_id');


        $ventasdiarios =  DB::table('ventasdiarios')
        ->where('clientes_id', $id)
        ->where('saldo_diario', '>', 0)->paginate(10);


        $title = "diarios sin saldar";
        return View::make('ventasdiarios.indexsinsaldar', array('title' => $title, 'ventasdiarios' => $ventasdiarios, 'id' => $id));

	}



	public function crearrecibos()
	{


		$id = Input::get('id');
		$ids = Input::get('ids');


		$rules = [
			'fecha' =>  array('required', 'date_format:"d-m-Y"'),
			'numero_comprobante' => 'required|numeric',
		];


		if (! Ventasdiario::isValid(Input::all(),$rules)) {
			return Redirect::back()->withInput()->withErrors( Ventasdiario::$errors)->with(array('clientes_id' => $id));
		}




		$empresas_id = Input::get('empresas_id');

		$importe_recibo = floatval(Input::get('importe_recibo'));
		$importe_recibo_generar = floatval(Input::get('importe_recibo'));

		$fecha = date("Y-m-d", strtotime(Input::get('fecha')));;

		if ($importe_recibo < 0) {
			echo "importe < 0";
			die;
		}

		$flash_message = "";

		$importe_recibo_total = 0;
		$importe_recibo_total_observaciones = "";



		$total_facturas_a_saldar=0;
		// calcula el total de facturas a pagar !


		$ventasdiarios =  DB::table('ventasdiarios')
		->where('clientes_id', $id)
		->whereIn('tiposdocumentos_id', array(1,2,3,4,7,10))
		->where('saldo_diario', '>', 0)->get();

		foreach ($ventasdiarios as $ventasdiario) {
			if (array_key_exists($ventasdiario->id, $ids)) {
					$total_facturas_a_saldar += $ventasdiario->saldo_diario;
			}
		}











		// suma todos los pagos a cuenta, notas de creditos y las cancela.


		$ventasdiarios =  DB::table('ventasdiarios')
																		->where('clientes_id', $id)
																		->whereIn('tiposdocumentos_id', array(6, 9, 11))
																		->where('saldo_diario', '>', 0)->get();


		foreach ($ventasdiarios as $ventasdiario) {
			if (array_key_exists($ventasdiario->id, $ids)) {
					$importe_recibo += $ventasdiario->saldo_diario;
					$vm = Ventasdiario::find($ventasdiario->id);
					$vm->saldo_diario = 0;
					$vm->estado = 'cerrada';
					$vm->save();
			}
		}




        $ventasdiarios =  DB::table('ventasdiarios')
        ->where('clientes_id', $id)
				->whereIn('tiposdocumentos_id', array(1,2,3,4,7,10))
        ->where('saldo_diario', '>', 0)->get();


		foreach ($ventasdiarios as $ventasdiario) {

			if (array_key_exists($ventasdiario->id, $ids)) {
			    // echo "el id " . $ventasdiario->id . " existe <br>";

			    if ($importe_recibo > 0 and $importe_recibo < $ventasdiario->saldo_diario) {

						$vm = Ventasdiario::find($ventasdiario->id);
						$vm->saldo_diario = $vm->saldo_diario - $importe_recibo;
						$vm->save();

						$importe_recibo_total += $importe_recibo;

						$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);

						$importe_recibo_total_observaciones .= "Pago parcial " . $tiposdocumento->tiposdocumento . ": " . $ventasdiario->numero_comprobante . "<br> ";

						$importe_recibo=0;

			    } elseif ($importe_recibo == $ventasdiario->saldo_diario) {

					$vm = Ventasdiario::find($ventasdiario->id);
					$vm->saldo_diario = 0;
					$vm->estado = 'cerrada';
					$vm->save();

					$importe_recibo_total += $importe_recibo;

					$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);

					$importe_recibo_total_observaciones .= "Pago saldo total " . $tiposdocumento->tiposdocumento . ": " . $ventasdiario->numero_comprobante;

					$importe_recibo=0;

				} elseif ($importe_recibo > $ventasdiario->saldo_diario) {

					$vm = Ventasdiario::find($ventasdiario->id);
					$vm->saldo_diario = 0;
					$vm->estado = 'cerrada';
					$vm->save();

					$importe_recibo_total += $ventasdiario->saldo_diario;

					$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);

					$importe_recibo_total_observaciones .= "Pago saldo total " . $tiposdocumento->tiposdocumento . ": " . $ventasdiario->numero_comprobante;


			    	$importe_recibo = $importe_recibo - $ventasdiario->saldo_diario;
				}


			}




		}

		// echo "Importe total del recibo a generar: " . $importe_recibo_total . "<br>";
		// echo "Observaciones: " . $importe_recibo_total_observaciones . "<br>";


		$cliente = Cliente::find($id);
		$responsabilidadesiva = Responsabilidadesiva::find($cliente->responsabilidadesivas_id);


		// Busca el proximo numero de nota de credito disponible, guarda para el nuevo recivo, y despues agrega 1 a la tabla tipo documento
		$tiposdocumento = Tiposdocumento::find($responsabilidadesiva->recibo_tiposdocumentos_id);


		$numero_comprobante = Input::get('numero_comprobante');

		$vm = new Ventasdiario();
		$vm->fecha = date("Y-m-d", strtotime(Input::get('fecha')));;
		$vm->fecha_vencimiento = date("Y-m-d", strtotime(Input::get('fecha')));;
		$vm->tiposdocumentos_id = $responsabilidadesiva->recibo_tiposdocumentos_id;
		$vm->numero_comprobante = $numero_comprobante;
		$vm->tipo_diario = 'haber';
		$vm->importe_total = $importe_recibo_generar;
		$vm->saldo_diario = 0;
		$vm->condicionesventas_id = 1;
		$vm->importe_gravado = 0;
		$vm->importe_no_gravado = 0;
		$vm->importe_iva = 0;
		$vm->importe_otros_impuestos = 0;
		$vm->porcentaje_bonificacion = 0;
		$vm->importe_bonificacion = 0;
		$vm->estado = 'cerrada';
		$vm->observaciones = $importe_recibo_total_observaciones;
		$vm->users_id = Auth::user()->id;
		$vm->clientes_id = $id;
		$vm->empresas_id = 1;

		$vm->save();

		$flash_message .="Se creo recibo correctamente.<br>";





		if ($importe_recibo > 0) {

					// busca proximo numero de documento
					$empresasdocumentosnumeros = DB::table('empresasdocumentosnumeros')
					->where('empresas_id', '=', 1)
					->where('tiposdocumentos_id', '=', 11)
					->first();

					$numero_comprobante = $empresasdocumentosnumeros->numero;

					// suma 1 al numero de comprobante
					$empresasdocumentosnumeros = Empresasdocumentosnumero::find($empresasdocumentosnumeros->id);
					$empresasdocumentosnumeros->numero = $empresasdocumentosnumeros->numero + 1;
					$empresasdocumentosnumeros->save();


					$vm = new Ventasdiario();
					$vm->fecha = date("Y-m-d", strtotime(Input::get('fecha')));;
					$vm->fecha_vencimiento = date("Y-m-d", strtotime(Input::get('fecha')));;
					$vm->tiposdocumentos_id = 11;
					$vm->numero_comprobante = $numero_comprobante;
					$vm->tipo_diario = 'haber';
					$vm->importe_total = $importe_recibo;
					$vm->saldo_diario = $importe_recibo;
					$vm->condicionesventas_id = 1;
					$vm->importe_gravado = 0;
					$vm->importe_no_gravado = 0;
					$vm->importe_iva = 0;
					$vm->importe_otros_impuestos = 0;
					$vm->porcentaje_bonificacion = 0;
					$vm->importe_bonificacion = 0;
					$vm->estado = 'abierto';
					$vm->observaciones = "Pago a cuentas por : " . $importe_recibo_total_observaciones;
					$vm->users_id = Auth::user()->id;
					$vm->clientes_id = $id;
					$vm->empresas_id = $empresas_id;

					$vm->save();

					$flash_message .="Se creo pago a cuentas.<br>";
		}


        return View::make('ventasdiarios.recibo')->with('flash_message', $flash_message);


	}


	public function imprimirrecibo($id)
	{

        $ventasdiario = Ventasdiario::find($id);

        $cliente = Cliente::find($ventasdiario->clientes_id);

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CodexControl.com');
		$pdf->SetTitle('Rebibo');

		// set default header data
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->SetHeaderData("../../../../../public/images/logo_empresa.jpg", PDF_HEADER_LOGO_WIDTH, "Cuenta Corriente", "Seguridad S.R.L.");

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);

		// add a page
		$pdf->AddPage();



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -



		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

		// create some HTML content
		$html = '<h1>Recibo Nº: ' . str_pad($ventasdiario->numero_comprobante, 12, '0', STR_PAD_LEFT) . '</h1>
		Cliente: ' . $cliente->cliente . '<br>
		Fecha: ' . $ventasdiario->fecha . '<br>
		Importe: ' . $ventasdiario->importe_total . '<br>
		Detalle: ' . $ventasdiario->observaciones . '<br><br><br><br><br>
		.................................<br>
		Recibi Conforme
		';

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');


		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('recibo.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+



	}


	public function ctactes()
	{

		$title = "Cuenta Corriente";
        return View::make('ventasdiarios.ctacteshow', array('title' => $title));

	}





	public function ctacteshow()
	{

		$cliente = Input::get('cliente', '');
		$clientes_id = Input::get('clientes_id', 0);
		$empresas_id = Input::get('empresas_id');

		$empresa = Empresa::find($empresas_id);

		if ($clientes_id > 0 and $cliente<>'') {

		        $ventasdiarios =  DB::table('ventasdiarios')
		        ->where('clientes_id', $clientes_id)
						->where('empresas_id', $empresas_id)
		        ->where('saldo_diario', '>', 0)
		        ->orderBy('clientes_id', 'asc')
		        ->get();

		} else {
		        $ventasdiarios =  DB::table('ventasdiarios')
		        ->where('estado', 'pendiente')
						->where('empresas_id', $empresas_id)
		        ->where('saldo_diario', '>', 0)
		        ->orderBy('clientes_id', 'asc')
		        ->get();
		}


		if (count($ventasdiarios) == 0 ) {
			echo "No encontre diarios.<br>";
			echo "<input type='button' value='Cerrar' onclick='self.close()'>";
			die;
		}

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CodexControl.com');
		$pdf->SetTitle('CtaCte');

		// set default header data
		$pdf->SetHeaderData("../../../../../public/images/logo_empresa.jpg", PDF_HEADER_LOGO_WIDTH, "Cuenta Corriente", $empresa->empresa);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);

		// add a page
		$pdf->AddPage();



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$html = "";



		$cliente_actual=0;

		$total_cliente = 0;

		$total_general = 0;

		$primera_vez = true;

		foreach ($ventasdiarios as $ventasdiario)
			{
					if ($cliente_actual<>$ventasdiario->clientes_id) {
						$cliente_actual = $ventasdiario->clientes_id;


						if ($primera_vez) {
							$primera_vez= false;
						} else {
							$html .= "<tr>";
					        $html .= "<td></td>";
							$html .= "<td></td>";
					        $html .= "<td align=\"right\">TOTAL CLIENTE</td>";
					        $html .= "<td align=\"right\">" . number_format($total_cliente, 2) . "</td>";
							$html .= "</tr>";

							$html .= "</table><br><br><br><br>";

							$total_cliente = 0;
						}


						$cliente = Cliente::find($cliente_actual);
						$html .= '<h3>Cliente: ' . $cliente->cliente . '</h3><br>';

						$html .= "<table>";

							$html .= "<tr>";
					        $html .= "<td>Fecha</td>";
					        $html .= "<td>Documento</td>";
					        $html .= "<td>Numero</td>";
					        $html .= "<td align=\"right\">Saldo diario</td>";
							$html .= "</tr>";

					}

					$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);


					$relleno_inicio = "";
					$relleno_fin = "";

					if ( $ventasdiario->tiposdocumentos_id == 1
								or $ventasdiario->tiposdocumentos_id == 2
								or $ventasdiario->tiposdocumentos_id == 3
								or $ventasdiario->tiposdocumentos_id == 4
								or $ventasdiario->tiposdocumentos_id == 7
								or $ventasdiario->tiposdocumentos_id == 8

					) {
							$total_cliente += $ventasdiario->saldo_diario;
							$total_general += $ventasdiario->saldo_diario;

					} elseif (
								   $ventasdiario->tiposdocumentos_id == 6
								or $ventasdiario->tiposdocumentos_id == 9
								or $ventasdiario->tiposdocumentos_id == 11
					) {
							$total_cliente -= $ventasdiario->saldo_diario;
							$total_general -= $ventasdiario->saldo_diario;
							$relleno_inicio = "(";
							$relleno_fin = ")";
					}

					$html .= "<tr>";

							$html .= "<td>" . $ventasdiario->fecha . "</td>";
							$html .= "<td>" . $tiposdocumento->tiposdocumento . "</td>";
							$html .= "<td>" . str_pad($ventasdiario->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
							$html .= "<td align=\"right\">" . $relleno_inicio . $ventasdiario->saldo_diario . $relleno_fin . "</td>";

					$html .= "</tr>";




			}

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\">TOTAL CLIENTE</td>";
	        $html .= "<td align=\"right\">" . number_format($total_cliente,2) . "</td>";
			$html .= "</tr>";

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\">TOTAL GENERAL</td>";
	        $html .= "<td align=\"right\">" . number_format($total_general,2) . "</td>";
			$html .= "</tr>";

			$html .= "</table><br><br><br><br>";



		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');


		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('recibo.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+



	}



	public function informeventas()
	{

		$title = "Informe Ventas";
        return View::make('ventasdiarios.ventashow', array('title' => $title));

	}




	public function ventashow()
	{



		$rules = [
			'fecha_desde' =>  array('required', 'date_format:"d-m-Y"'),
			'fecha_hasta' =>  array('required', 'date_format:"d-m-Y"'),
			'empresas_id' => 'exists:empresas,id',
		];




		if (! Ventasdiario::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Ventasdiario::$errors);

		}

		$fecha_desde = date("Y-m-d", strtotime(Input::get('fecha_desde')));
		$fecha_hasta = date("Y-m-d", strtotime(Input::get('fecha_hasta')));
		$empresas_id = Input::get('empresas_id');


		$empresa = Empresa::find($empresas_id);

        $ventasdiarios =  DB::table('ventasdiarios')
        ->where('fecha', '>=', $fecha_desde)
        ->where('fecha', '<=', $fecha_hasta)
				->where('empresas_id', '=', $empresas_id)
        ->whereIn('tiposdocumentos_id', array(1, 2, 3, 4))
        ->whereIn('estado', array('cerrada', 'pendiente'))
        ->orderBy('fecha', 'asc')
        ->get();


		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CodexControl.com');
		$pdf->SetTitle('Ventas entre Fechas');

		// set default header data
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->SetHeaderData("../../../../../public/images/logo_empresa.jpg", PDF_HEADER_LOGO_WIDTH, "Informe Ventas", $empresa->empresa);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);

		// add a page
		$pdf->AddPage();



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$html = "";



		$total_general = 0;
		$total_iva = 0;


		$html .= '<h1>Informe de ventas entre fechas</h1><br>';
		$html .= '<h3>desde: ' . $fecha_desde . ' hasta: ' . $fecha_hasta . '</h3><br>';

		$html .= "<table>";

			$html .= "<tr>";
	        $html .= "<td>Fecha</td>";
	        $html .= "<td>Cliente</td>";
	        $html .= "<td>Documento</td>";
	        $html .= "<td>Numero</td>";
	        $html .= "<td align=\"right\">Iva</td>";
	        $html .= "<td align=\"right\">Importe</td>";
			$html .= "</tr>";




		foreach ($ventasdiarios as $ventasdiario)
			{

					$cliente = Cliente::find($ventasdiario->clientes_id);
					$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);

					$html .= "<tr>";

			        $html .= "<td>" . $ventasdiario->fecha . "</td>";
			        $html .= "<td>" . $cliente->cliente . "</td>";
			        $html .= "<td>" . $tiposdocumento->tiposdocumento . "</td>";
			        $html .= "<td>" . str_pad($ventasdiario->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
			        $html .= "<td align=\"right\">" . $ventasdiario->importe_iva . "</td>";
			        $html .= "<td align=\"right\">" . $ventasdiario->importe_total . "</td>";

					$html .= "</tr>";

					$total_iva += $ventasdiario->importe_iva;
			    	$total_general += $ventasdiario->importe_total;
			}

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\"><br></td>";
	        $html .= "<td align=\"right\"></td>";
			$html .= "</tr>";

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\">TOTAL GENERAL</td>";
	        $html .= "<td align=\"right\">" . number_format($total_iva,2) . "</td>";
	        $html .= "<td align=\"right\">" . number_format($total_general,2) . "</td>";
			$html .= "</tr>";

			$html .= "</table>";



		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');


		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('informe_ventas.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+



	}




	public function informerecibos()
	{

		$title = "Informe Recibos";
        return View::make('ventasdiarios.reciboshow', array('title' => $title));

	}




	public function reciboshow()
	{

		$rules = [
			'fecha_desde' =>  array('required', 'date_format:"d-m-Y"'),
			'fecha_hasta' =>  array('required', 'date_format:"d-m-Y"'),
			'empresas_id' => 'exists:empresas,id',
		];

		if (! Ventasdiario::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Ventasdiario::$errors);

		}


		$fecha_desde = date("Y-m-d", strtotime(Input::get('fecha_desde')));
		$fecha_hasta = date("Y-m-d", strtotime(Input::get('fecha_hasta')));
		$empresas_id = Input::get('empresas_id');

		$empresa = Empresa::find($empresas_id);

        $ventasdiarios =  DB::table('ventasdiarios')
        ->where('fecha', '>=', $fecha_desde)
        ->where('fecha', '<=', $fecha_hasta)
				->where('empresas_id', '=', $empresas_id)
        ->whereIn('tiposdocumentos_id', array(5))
        ->whereIn('estado', array('cerrada'))
        ->orderBy('fecha', 'asc')
        ->get();


		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CodexControl.com');
		$pdf->SetTitle('Ventas entre Fechas');

		// set default header data
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->SetHeaderData("../../../../../public/images/logo_empresa.jpg", PDF_HEADER_LOGO_WIDTH, "Cuenta Corriente", $empresa->empresa);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);

		// add a page
		$pdf->AddPage();



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$html = "";



		$total_general = 0;
		$total_iva = 0;


		$html .= '<h1>Informe de Recibos entre fechas</h1><br>';
		$html .= '<h3>desde: ' . $fecha_desde . ' hasta: ' . $fecha_hasta . '</h3><br>';

		$html .= "<table>";

			$html .= "<tr>";
	        $html .= "<td>Fecha</td>";
	        $html .= "<td>Cliente</td>";
	        $html .= "<td>Documento</td>";
	        $html .= "<td>Numero</td>";
	        $html .= "<td align=\"right\">Importe</td>";
			$html .= "</tr>";




		foreach ($ventasdiarios as $ventasdiario)
			{

					$cliente = Cliente::find($ventasdiario->clientes_id);
					$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);

					$html .= "<tr>";

			        $html .= "<td>" . $ventasdiario->fecha . "</td>";
			        $html .= "<td>" . $cliente->cliente . "</td>";
			        $html .= "<td>" . $tiposdocumento->tiposdocumento . "</td>";
			        $html .= "<td>" . str_pad($ventasdiario->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
			        $html .= "<td align=\"right\">" . $ventasdiario->importe_total . "</td>";

					$html .= "</tr>";


			    	$total_general += $ventasdiario->importe_total;
			}

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\"></td>";
			$html .= "</tr>";

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\">TOTAL GENERAL</td>";
	        $html .= "<td align=\"right\">" . number_format($total_general,2) . "</td>";
			$html .= "</tr>";

			$html .= "</table>";



		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');


		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('informe_ventas.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+



	}




	public function informemayor()
	{

		$title = "Informe Mayor";
        return View::make('ventasdiarios.mayorshow', array('title' => $title));

	}




	public function mayorshow()
	{

		$rules = [
			'clientes_id' => 'exists:clientes,id',
			'fecha_desde' =>  array('required', 'date_format:"d-m-Y"'),
			'fecha_hasta' =>  array('required', 'date_format:"d-m-Y"'),
			'empresas_id' => 'exists:empresas,id',
		];

		if (! Ventasdiario::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Ventasdiario::$errors);

		}



		$clientes_id = Input::get('clientes_id');
		$empresas_id = Input::get('empresas_id');

		$cliente = Cliente::find($clientes_id);
		$empresa = Empresa::find($empresas_id);

		$fecha_desde = date("Y-m-d", strtotime(Input::get('fecha_desde')));
		$fecha_hasta = date("Y-m-d", strtotime(Input::get('fecha_hasta')));

		$debe = DB::table('ventasdiarios')
		->whereIn('tiposdocumentos_id', array(1,2,3,4,7,10))
		->where('clientes_id', '=', $clientes_id)
		->where('empresas_id', '=', $empresas_id)
		->where('fecha', '<', $fecha_desde)
		->where('estado', 'cerrada')
		->sum('importe_total');



		$haber = DB::table('ventasdiarios')
		->whereIn('tiposdocumentos_id', array(5,6,9))
		->where('clientes_id', '=', $clientes_id)
		->where('empresas_id', '=', $empresas_id)
		->where('fecha', '<', $fecha_desde)
		->where('estado', 'cerrada')
		->sum('importe_total');




        $ventasdiarios =  DB::table('ventasdiarios')
        ->whereIn('tiposdocumentos_id', array(1,2,3,4,5,6,7,9,10))
				->where('clientes_id', '=', $clientes_id)
				->where('empresas_id', '=', $empresas_id)
        ->where('fecha', '>=', $fecha_desde)
        ->where('fecha', '<=', $fecha_hasta)
        ->orderBy('fecha', 'asc')
        ->get();



		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CodexControl.com');
		$pdf->SetTitle('Ventas entre Fechas');

		// set default header data
		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->SetHeaderData("../../../../../public/images/logo_empresa.jpg", PDF_HEADER_LOGO_WIDTH, "Informe Mayor", $empresa->empresa);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);

		// add a page
		$pdf->AddPage();



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		$html = "";



		$saldo = $haber - $debe;



		$html .= '<h1>Informe Mayor</h1><br>';
		$html .= '<h2>Cliente: ' . $cliente->cliente . '</h2><br>';
		$html .= '<h3>desde: ' . $fecha_desde . ' hasta: ' . $fecha_hasta . '</h3><br>';

		$html .= "<table>";

			$html .= "<tr>";
	        $html .= "<td>Fecha</td>";
	        $html .= "<td>Documento</td>";
	        $html .= "<td>Numero</td>";
	        $html .= "<td align=\"right\">Debe</td>";
	        $html .= "<td align=\"right\">Haber</td>";
	        $html .= "<td align=\"right\">Saldo</td>";
			$html .= "</tr>";

			$html .= "<tr>";
	        $html .= "<td></td>";
	        $html .= "<td></td>";
	        $html .= "<td></td>";
	        $html .= "<td align=\"right\">" . number_format($debe,2) . "</td>";
	        $html .= "<td align=\"right\">" . number_format($haber,2) . "</td>";
	        $html .= "<td align=\"right\">" . number_format($saldo,2) . "</td>";
			$html .= "</tr>";




		foreach ($ventasdiarios as $ventasdiario)
			{


					if ($ventasdiario->fecha >= $fecha_desde and $ventasdiario->fecha <= $fecha_hasta) {
						$cliente = Cliente::find($ventasdiario->clientes_id);
						$tiposdocumento = Tiposdocumento::find($ventasdiario->tiposdocumentos_id);

						$html .= "<tr>";

				        $html .= "<td>" . $ventasdiario->fecha . "</td>";
				        $html .= "<td>" . $tiposdocumento->tiposdocumento . "</td>";
				        $html .= "<td>" . str_pad($ventasdiario->numero_comprobante, 12, '0', STR_PAD_LEFT) . "</td>";
				        	if ($ventasdiario->tipo_diario == "debe") {
				        		$html .= "<td align=\"right\">" . $ventasdiario->importe_total . "</td>";

				        		if ($ventasdiario->condicionesventas_id == 1) {
				        			$html .= "<td align=\"right\">" . $ventasdiario->importe_total . "</td>";
				        			$saldo -= $ventasdiario->importe_total;
				        		} else {
				        			$html .= "<td align=\"right\"></td>";
				        		}

								$saldo += $ventasdiario->importe_total;



				        	} else {
				        		$html .= "<td align=\"right\"></td>";
				        		$html .= "<td align=\"right\">" . $ventasdiario->importe_total . "</td>";
				        		$saldo -= $ventasdiario->importe_total;

				        	}
				        $html .= "<td align=\"right\">" . number_format($saldo,2) . "</td>";

						$html .= "</tr>";
					}



			}

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\"></td>";
			$html .= "</tr>";

			$html .= "<tr>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
			$html .= "<td></td>";
	        $html .= "<td align=\"right\">SALDO GENERAL</td>";
	        $html .= "<td align=\"right\">" . number_format($saldo,2) . "</td>";
			$html .= "</tr>";

			$html .= "</table>";



		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');


		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('informe_ventas.pdf', 'I');

		//============================================================+
		// END OF FILE
		//============================================================+



	}



/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function notacredito()
{



			$ventasdiarios = DB::table('ventasdiarios')
														->where('estado', 'abierto')
														->whereIn('tiposdocumentos_id', array(6, 9))
														->paginate(15);

			$title = "Notas de Creditos";


			return View::make('ventasdiarios.indexnc', array('title' => $title, 'ventasdiarios' => $ventasdiarios));


}





/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function notacreditoedit($id)
{



				$ventasdiario = Ventasdiario::find($id);

				$title = "Cuerpo diarios";
				return View::make('ventasdiarios.show', array('title' => $title, 'ventasdiario' => $ventasdiario));



}



/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function notacreditocreate()
{

	$title = "Nota de Credito";

			return View::make('ventasdiarios.notacreditocreate', array('title' => $title));

}



/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function verfacturasparanc()
{

		$rules = [
			'clientes_id' => 'exists:clientes,id',
			'fecha' =>  array('required', 'date_format:"d-m-Y"')
		];


		if (! Ventasdiario::isValid(Input::all(),$rules)) {
					return Redirect::back()->withInput()->withErrors(Ventasdiario::$errors);
		}

		$clientes_id = Input::get('clientes_id');
		$empresas_id = Input::get('empresas_id');
		$fecha = Input::get('fecha');

		$cliente = Cliente::find($clientes_id);


		$ventasdiarios = DB::table('ventasdiarios')
																	->where('clientes_id', $clientes_id)
																	->where('empresas_id', $empresas_id)
																	->whereIn('estado', array('cerrada', 'pendiente'))
																	->whereIn('tiposdocumentos_id', array(1, 2, 3, 4, 6, 9))
																	->paginate(10);

		$title = "Facturas";
		return View::make('ventasdiarios.indexfacturasparanc',
												array(
													'title' => $title,
													'ventasdiarios' => $ventasdiarios,
													'cliente' => $cliente,
													'empresas_id' => $empresas_id,
													'fecha' => $fecha,

													));


}






/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function nccreate()
{


		$fecha = Input::get('fecha');

    list($dd,$mm,$yy)=explode("-",$fecha);


    $fechas = new DateTime();
		$fechas->setDate($yy, $mm, $dd);
    $fecha= $fechas->format('Y-m-d');

		$clientes_id = Input::get('clientes_id');
		$empresas_id = Input::get('empresas_id');

		$sinseleccion = Input::get('sinseleccion');
		$ventasdiarios_id = Input::get('ventasdiarios_id');


		$cliente = Cliente::find($clientes_id);

		$ventasdiarioNC = new Ventasdiario;

		$ventasdiarioNC->fecha = $fecha;
		$ventasdiarioNC->fecha_vencimiento = $fecha;

		if ($cliente->responsabilidadesivas_id == 7) {
				$ventasdiarioNC->tiposdocumentos_id = 6;
		} else {
				$ventasdiarioNC->tiposdocumentos_id = 9;
		}

		$ventasdiarioNC->empresas_id = $empresas_id;

		$responsabilidadesiva = Responsabilidadesiva::find($cliente->responsabilidadesivas_id);

		$tiposdocumentos_id = $responsabilidadesiva->nc_tiposdocumentos_id;

		$empresasdocumentosnumeros = DB::table('empresasdocumentosnumeros')
					->where('empresas_id', '=', $empresas_id)
					->where('tiposdocumentos_id', '=', $tiposdocumentos_id)
					->first();

		$numero_comprobante = $empresasdocumentosnumeros->numero;

		$empresasdocumentosnumeros = Empresasdocumentosnumero::find($empresasdocumentosnumeros->id);

		$empresasdocumentosnumeros->numero = $empresasdocumentosnumeros->numero + 1;
		$empresasdocumentosnumeros->save();

		$ventasdiarioNC->numero_comprobante = $numero_comprobante;

		$ventasdiarioNC->tipo_diario = "haber";
		$ventasdiarioNC->importe_total = 0;
		$ventasdiarioNC->saldo_diario = 0;
		$ventasdiarioNC->condicionesventas_id = 1;
		$ventasdiarioNC->importe_gravado = 0;
		$ventasdiarioNC->importe_no_gravado = 0;
		$ventasdiarioNC->importe_iva = 0;
		$ventasdiarioNC->importe_otros_impuestos = 0;
		$ventasdiarioNC->porcentaje_bonificacion = 0;
		$ventasdiarioNC->importe_bonificacion = 0;
		$ventasdiarioNC->estado = "abierto";
		$ventasdiarioNC->observaciones="";
		$ventasdiarioNC->users_id = 3;
		$ventasdiarioNC->clientes_id = $clientes_id;

		$ventasdiarioNC->save();

		$id_nuevo = $ventasdiarioNC->id;



		$ventasdiarioscuerpos = DB::table('ventasdiarioscuerpos')
																	->where('ventasdiarios_id', $ventasdiarios_id)
																	->get();


		// echo count($ventasdiarioscuerpos);
		// die;
		//
		//




		if (count($ventasdiarioscuerpos)) {





		foreach ($ventasdiarioscuerpos as $ventasdiarioscuerpo)
			{


						$ventasdiarioscuerpo_new = new Ventasdiarioscuerpo;


						$ventasdiarioscuerpo_new->ventasdiarios_id = $id_nuevo;
						$ventasdiarioscuerpo_new->cantidad = $ventasdiarioscuerpo->cantidad;
						$ventasdiarioscuerpo_new->articulos_id = $ventasdiarioscuerpo->articulos_id;
						$ventasdiarioscuerpo_new->articulo = $ventasdiarioscuerpo->articulo;
						$ventasdiarioscuerpo_new->importe_gravado = $ventasdiarioscuerpo->importe_gravado;
						$ventasdiarioscuerpo_new->importe_no_gravado = $ventasdiarioscuerpo->importe_no_gravado;
						$ventasdiarioscuerpo_new->importe_iva = $ventasdiarioscuerpo->importe_iva;
						$ventasdiarioscuerpo_new->porcentaje_iva = $ventasdiarioscuerpo->porcentaje_iva;
						$ventasdiarioscuerpo_new->importes_otros_impuestos = $ventasdiarioscuerpo->importes_otros_impuestos;
						$ventasdiarioscuerpo_new->porcentaje_bonificacion = $ventasdiarioscuerpo->porcentaje_bonificacion;
						$ventasdiarioscuerpo_new->precio_total = $ventasdiarioscuerpo->precio_total;

						$ventasdiarioscuerpo_new->save();



			}

		}

$ventasdiarios = DB::table('ventasdiarios')
											->where('estado', 'abierto')
											->whereIn('tiposdocumentos_id', array(6, 9))
											->paginate(15);

$title = "Notas de Creditos";

return View::make('ventasdiarios.indexnc', array('title' => $title, 'ventasdiarios' => $ventasdiarios));




}


/**
 * Show the form for creating a new resource.
 *
 * @return Response
 */
public function cuentacorriente()
{

	$cuentas = DB::table('cuentas')
												->orderby('cuenta', 'asc')
												->paginate(100);
	$title = "Cuentas";
			return View::make('diarios.indexctacte', array('title' => $title, 'cuentas' => $cuentas));

}

public function cuentacteshow($id)
{

			$diarios = DB::table('diarios')
														->where('cuentas_id','=', $id)
														->orderby('id', 'asc')
														->paginate(50);
			$title = "Diario de cliente: $id";
			return View::make('diarios.cuentacteshow', array('title' => $title, 'diarios' => $diarios));
}




/**
 * Show the form for creating a new resource.
 *
 * @return Response
 */
public function planilla()
{
			$title = "Ver planilla";
			return View::make('diarios.planilla', array('title' => $title));

}

public function planillashow()
{

		$hoy = date("Y-m-d", strtotime(Input::get('fecha')));

		// $hoy = Carbon::now($hoy);
		// $hoy = $hoy->format('Y-m-d');
		// echo $hoy;
		// die;



		$diarios = DB::table('diarios')
													->whereRaw("DATE(created_at) = '$hoy'")
													->orderby('id', 'asc')
													->paginate(50);
		$title = "Planilla de " . $hoy;
		return View::make('diarios.index', array('title' => $title, 'diarios' => $diarios));


}

















}
