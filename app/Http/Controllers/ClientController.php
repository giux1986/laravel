<?php namespace App\Http\Controllers;
use App\Client;
use DB;
use App\Photos;
use Input;
use Mail;
use Validator;
class ClientController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| ClientController
	|--------------------------------------------------------------------------
	|

	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	 public function toArray($obj)
	{
		if (is_object($obj)) $obj = (array)$obj;
		if (is_array($obj)) {
			$new = array();
			foreach ($obj as $key => $val) {
				$new[$key] = $this->toArray($val);
			}
		} else {
			$new = $obj;
		}
	
		return $new;
	}
	
	public function index()
	{
		$clients = DB::table('clients')->get();
		$arrayClientes=array();
		foreach($clients as $client){
			$clientA=$this->toArray($client);
			$clientA["photos"]= $this->getPhotos($clientA["id"]);
			array_push($arrayClientes,$clientA);
			unset($clientA);
		}
		return view('clients/all', ['clients' => $arrayClientes]);
	}
	public function register()
	{
		return view('clients/register');
	}
	public function delete()
	{
		DB::table('clients')->where("id","=",$_GET["id"])->delete();
		$photos=DB::table('photosxclient')->where("client_id","=",$_GET["id"])->get();
		foreach($photos as $photo){
			DB::table('photosxclient')->where("id","=",$photo->id)->delete();
			unlink (public_path()."/uploads/".$photo->path);
		}
		return redirect("getClients");
	}
	
	public function edit()
	{
		if(isset($_POST["id"])){
			$rules= [
			'name' => 'required|max:255|min:2',
			'lastname' => 'required|max:255|min:2',
			'dob' => 'required|date_format:Y-n-j',
			'phone' => 'required|digits_between:6,12'
		];
		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()){
			return redirect("edit?id=$_POST[id]")->withErrors($validator);
		}
			DB::table('clients')
            ->where('id',"=", $_POST["id"])
            ->update(['name' => $_POST["name"],'lastname' => $_POST["lastname"],'dob' => $_POST["dob"],'phone' => $_POST["phone"]]);
			$photoNumber=count($_FILES["photos"]["name"]);
			for($i=0;$i<$photoNumber;$i++){
	
				$tmp_name = $_FILES["photos"]["tmp_name"][$i];
				$name = date("YmdHis").$_FILES["photos"]["name"][$i];
				move_uploaded_file($tmp_name,public_path()."/uploads/".$name);
				Photos::create([
					'client_id' => $_POST["id"],
					'path' => $name,
					
				]);	
			}
			return redirect("getClients");
		}
		else{
			$client=DB::table('clients')->where("id","=",$_GET["id"])->first();
			$clientA=$this->toArray($client);
			$clientA["photos"]= $this->getPhotos($clientA["id"]);
			return view('clients/edit', ['client' => $clientA]);
		}
	}
	
	public function create()
	{
		$rules= [
			'name' => 'required|max:255|min:2',
			'lastname' => 'required|max:255|min:2',
			'dob' => 'required|date_format:Y-n-j',
			'phone' => 'required|digits_between:6,12'
		];
		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()){
			return redirect("register")->withErrors($validator);
		}
		$client=Client::create([
				'name' => $_POST['name'],
				'lastname' => $_POST['lastname'],
				'dob' =>$_POST['dob'],
				'phone' => $_POST['phone'],
			]);
			$photoNumber=count($_FILES["photos"]["name"]);
		for($i=0;$i<$photoNumber;$i++){

			$tmp_name = $_FILES["photos"]["tmp_name"][$i];
			$name = date("YmdHis").$_FILES["photos"]["name"][$i];
			move_uploaded_file($tmp_name,public_path()."/uploads/".$name);
			Photos::create([
				'client_id' => $client->id,
				'path' => $name,
				
			]);	
		}
		Input::merge(array('email'=>'giux1986@gmail.com','name'=>'test')); 

		Mail::send('emails.welcome', array('post' => $_POST), function($msg) {
		   $msg->from('giux1986@gmail.com', 'Laravel Admin');
		   $msg->to(Input::get('email'), Input::get('name'))->subject('You have');
		});
		return redirect("getClients");
	}
	
	public function getPhotos($id){
		return DB::table('photosxclient')->where("client_id","=",$id)->get();	
	}
	public function deletePhoto()
	{
		$photo=DB::table('photosxclient')->where("id","=",$_GET["id"])->first();
		DB::table('photosxclient')->where("id","=",$_GET["id"])->delete();
		unlink (public_path()."/uploads/".$photo->path);
		$client=DB::table('clients')->where("id","=",$_GET["client"])->first();
		$clientA=$this->toArray($client);
		$clientA["photos"]= $this->getPhotos($clientA["id"]);
		
		return view('clients/edit', ['client' => $clientA]);
	}

}
