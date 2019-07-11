<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class WeatherController extends Controller
{
    private $cities = [
      'DP' => [
          'temperature' => 26,
          'humidity' => 63,
          'wind_speed' => 5
      ],
        'DUBAI' => [
          'temperature' => 45,
          'humidity' => 33,
          'wind_speed' => 2
      ],
        'KIEV' => [
          'temperature' => 30,
          'humidity' => 65,
          'wind_speed' => 21
      ],

    ];
    public function getWeather($city)
    {
        if (!isset($this->cities[$city])) {
            return response()->json(
                [
                    'error' => 'City not found',
                    'error_code' => '100500'
                ]
            , Response::HTTP_NOT_FOUND);
        }
        return response()->json(
            $this->cities[$city]
        );
    }

    public function getWeathers()
    {
        return response()->json(
            $this->cities, Response::HTTP_OK
        );
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request,
                [
                    'city' => 'required',
                    'temp' => 'required'
                ]
            );

            if (isset($this->cities[$request->city])) {
                return response()->json(
                    ['error' => 'city already exists'], Response::HTTP_CONFLICT
                );
            }

            return response()->json([], Response::HTTP_CREATED, [
                'Location' => 'http://localhost:8088/weather/'.$request->city
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'invalid data'
            ], Response::HTTP_BAD_REQUEST);
        }


    }
}