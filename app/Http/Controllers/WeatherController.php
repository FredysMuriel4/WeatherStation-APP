<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Traits\ConsultationHistoryTrait;
use App\Models\ConsultationHistory;

class WeatherController extends Controller
{
    use ConsultationHistoryTrait;
    public function index()
    {
        return view('index');
    }

    public function getCityWeather(Request $request)
    {
        try {
            $data = json_decode($request->q);
            $lat = $data->lat;
            $lng = $data->lng;

            $apiKey = config('services.openweathermap.key');

            $client = new Client();
            $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lng&appid=$apiKey";
            $response = $client->get($url);

            $response_data = json_decode($response->getBody(), true);

            $get_ip = $this->getIp();
            if($get_ip['state'] != 200) {
                return response()->json($get_ip);
            }

            $ip = $get_ip['data'];

            $store_consult = $this->storeConsultationHistory($ip, $response_data);

            if($store_consult['state'] != 201) {
                return response()->json($store_consult);
            }

            return response()->json([
                'state' => 200,
                'data' => $response_data,
                'error' => '',
                'message' => 'Data'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'state' => 500,
                'error' => $e->getMessage(),
                'message' => 'Server error'
            ]);
        }
    }

    public function history(Request $request)
    {
        $get_ip = $this->getIp();
        $ip = $get_ip['data'];

        $history = ConsultationHistory::where('ip', $ip)
            ->orderBy('id', 'DESC')
            ->created($request->from, $request->to)
            ->paginate(10);

        $history->getCollection()->transform(function ($item) {
            $item->consult = json_decode($item->consult, true);
            $real_temp = $item->consult['main']['temp'];
            $celcius_temp = ($real_temp - 273.15);
            $fahrenheit_temp = (($celcius_temp * (9/5)) + 32);
            $item->celcius_temp = round($celcius_temp);
            $item->fahrenheit_temp = round($fahrenheit_temp);
            return $item;
        });

        $request_params = $request->query();
        $history->appends($request_params);

        return view('history', [
            'history' => $history
        ]);
    }

    public function getIp()
    {
        try {
            $client = new Client();

            $url = 'https://api.ipify.org/';
            $response = $client->get($url);
            $body = $response->getBody();
            $ip = $body->getContents();

            return [
                'state' => 200,
                'data' => $ip,
                'error' => '',
                'message' => 'Ip del usuario'
            ];
        } catch (\Exception $e) {
            return [
                'state' => 500,
                'error' => $e->getMessage(),
                'message' => 'Server error'
            ];
        }
    }
}
