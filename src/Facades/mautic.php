<?php namespace Vladko\Mautic\Facades;

use Illuminate\Support\Facades\Facade;

class Mautic extends Facade {

    protected static function getFacadeAccessor()
    {
    	return 'mautic';
 	}
}