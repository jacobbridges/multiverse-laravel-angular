<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('hello');
// });

Route::get('/', function()
{
    $universe = new Cosmos\Universe;
    $universe2 = new Cosmos\Universe;
    
    echo "<pre>";
	print_r ($universe);
    echo "</pre>";
    
    echo "<pre>";
	print_r ($universe2);
    echo "</pre>";
});

Route::get('forte', function()
{
    return View::make('hello');
});

