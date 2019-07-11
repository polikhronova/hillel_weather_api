<?php

$router->get('/weather/{city}', 'WeatherController@getWeather');
$router->get('/weathers', 'WeatherController@getWeathers');
$router->post('/weather', 'WeatherController@store');
