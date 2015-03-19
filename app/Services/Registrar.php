<?php namespace App\Services;

use App\Client;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'lastname' => 'required|max:255',
			'dob' => 'required|max:255',
			'phone' => 'required|max:10'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return Client::create([
			'name' => $data['name'],
			'lastname' => $data['lastname'],
			'dob' =>$data['dob'],
			'phone' => $data['phone'],
		]);
	}

}
