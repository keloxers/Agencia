<?php

class JuegosController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $agentes = DB::table('agentes')
															->orderby('id', 'asc')
															->get();
        $title = "Juegos";

        return View::make('juegos.index', array('title' => $title, 'agentes' => $agentes));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('juegos.create');
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
			'cartons_id' => 'exists:cartons,id',
			'valor_juego' => 'numeric|required',
			'agentes_id' => 'exists:agentes,id',
			'sorteo' => 'required',
			'entregados' => 'numeric',
			'devolucion' => 'numeric'
		];

		if (! Juego::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Juego::$errors);

		}

		$juego = new Juego;

		$juego->agentes_id = Input::get('agentes_id');
		$juego->cartons_id = Input::get('cartons_id');
		$juego->sorteo = Input::get('sorteo');
		$juego->valor_juego =  Input::get('valor_juego');
		$juego->entregados = Input::get('entregados');
		$juego->devolucion = Input::get('devolucion');
		$juego->vendidos = $juego->entregados - $juego->devolucion;
		$juego->neto = $juego->vendidos * $juego->valor_juego;
		$juego->agencia = $juego->neto * 0.05;
		$juego->agente = $juego->neto * 0.10;
		$juego->a_pagar = $juego->neto - $juego->agente;
		$juego->pagado = 0;
		$juego->deuda = $juego->pagado - $juego->a_pagar;

		$juego->save();

		return Redirect::to('/juegos');

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$juego = Juego::find($id);
		$title = "Editar juego";

        return View::make('juegos.edit', array('title' => $title, 'juego' => $juego));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{


		// echo Input::get('vendidos');
		// $input = Input::all();
		// var_dump($input);
		// die;

		$rules = [
			'cartons_id' => 'exists:cartons,id',
			'valor_juego' => 'numeric|required',
			'agentes_id' => 'exists:agentes,id',
			'sorteo' => 'required',
			'entregados' => 'numeric',
			'devolucion' => 'numeric'
		];

		if (! Juego::isValid(Input::all(),$rules)) {

			return Redirect::back()->withInput()->withErrors(Juego::$errors);

		}

		$juego = Juego::find($id);

		$juego->agentes_id = Input::get('agentes_id');
		$juego->cartons_id = Input::get('cartons_id');
		$juego->sorteo = Input::get('sorteo');
		$juego->valor_juego =  Input::get('valor_juego');
		$juego->entregados = Input::get('entregados');
		$juego->devolucion = Input::get('devolucion');
		$juego->vendidos = $juego->entregados - $juego->devolucion;
		$juego->neto = $juego->vendidos * $juego->valor_juego;
		$juego->agencia = $juego->neto * 0.05;
		$juego->agente = $juego->neto * 0.10;
		$juego->a_pagar = $juego->neto - $juego->agente;
		$juego->pagado = 0;
		$juego->deuda = $juego->pagado - $juego->a_pagar;

		$juego->save();

		return Redirect::to('/juegos');


	}



public function saldar($id)
{
	$juego = Juego::find($id);
	$a_pagar = $juego->a_pagar;
	$juego->pagado = $a_pagar;
	$juego->deuda = 0;
	$juego->save();

	return Redirect::to('/juegos');
}







}
