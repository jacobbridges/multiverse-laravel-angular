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
    $time = -microtime(true); 
    $universe = new Cosmos\Universe;
    for ($i=0; $i<10; $i++)
    {
        $universe->generateGalaxy();
    }
    
    $galaxies = $universe->getGalaxies();
    
    echo "<pre>";
	print_r ($universe);
    echo "</pre>";
    
    echo "<pre>";
	print_r ($galaxies);
    echo "</pre>";
    
    $time += microtime(true);
    echo "\n<br>Execution Time: " . sprintf('%0.4f', $time) . " seconds \n<br>";
});

Route::get('forte', function()
{
    return View::make('hello');
});

