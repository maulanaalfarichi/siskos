<?php

namespace Bukosan\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Currency extends Facade
{
	
	protected static function getFacadeAccessor()
	{
		return "currency";
	}
	
}