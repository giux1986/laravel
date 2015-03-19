<?php namespace App;
use App\Client;
class Helpers
{
    function getPhotos($id){
		return App\Client::getPhotos($id);
	}
}