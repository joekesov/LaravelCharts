<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Device;

class DeviceController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        try {
            $statusCode = 200;
            $response = $this->getDeviceResponseData($code);
        } catch (\Exception $e) {

            $response = [
                "error" => "File doesn`t exists"
            ];
            $statusCode = 404;
        } finally {
            return response()->json($response, $statusCode);
        }
    }

    /**
     * @param $code
     * @return array
     */
    private function getDeviceResponseData($code)
    {
        $response = [
            'id' => $code,
            'bat' => 997,
            'data' => $this->getIndicatorsData($code)
        ];

        return $response;
    }

    /**
     * @param $code
     * @return array
     */
    private function getIndicatorsData($code)
    {
        $indicators = array();

        $time = time();
        for ($i = rand(5, 10); $i > 0; $i--) {
            $indicator['timestamp'] = $time - $i * 15 * 60;
            $indicator['pressure'] = rand(300, 555) / 10;
            $indicators[] = $indicator;
        }

        return $indicators;
    }
}
