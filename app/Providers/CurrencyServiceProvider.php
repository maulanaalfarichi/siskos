<?php

namespace Bukosan\Providers;

use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
	
	public function register()
	{
		$this->app->bind(
			'currency',
			'Bukosan\Support\Classes\Currency'
		);
	}
	
}