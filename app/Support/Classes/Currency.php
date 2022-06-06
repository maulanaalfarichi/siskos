<?php

namespace Bukosan\Support\Classes;

use NumberFormatter;

class Currency
{
	
	private $local = 'id-ID';
	
	private $formatter;
	
	public function __construct()
	{
		$this->formatter = new NumberFormatter($this->local,2);
	}
	
	public function format($currency,$type = NULL)
	{
		return $this->formatter->format($currency);
	}
	
	public function pricing($price1, $price2){
		if($price1 == $price2){
			return $this->format($price1);
		}
		else{
			if($price1 < $price2)
				return $this->format($price1) . ' - ' . $this->format($price2);
			else
				return $this->format($price2) . ' - ' . $this->format($price1);
		}
	}
	
}