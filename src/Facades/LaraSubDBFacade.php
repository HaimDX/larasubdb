<?php

namespace HaimDX\LaraSubDB\Facades;
use Illuminate\Support\Facades\Facade;


/**
 * Class ShoppingCartFacade
 * @package LaraShout\ShoppingCart
 */
class LaraSubDBFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larasubdb';
    }
}