<?php

class SessionsController extends BaseController {


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('sessions.create');
	}

	public function store()
	{
		
		$input = Input::all();


		$attempt = Auth::attempt([
			'email' => $input['email'],
			'password' => $input['password']
		]);

		// var_dump($attempt);
		// die;

		if($attempt) return Redirect::intended('/')->with('flash_message', 'Tu estas logeado !');

		return Redirect::intended('/')->with('flash_message', 'Error en las credenciales !');

	}


	public function destroy()
	{
		Auth::logout();

		return Redirect::home()->with('flash_message', 'Tu session se ha cerrado !');


	}

}
