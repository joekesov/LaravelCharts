<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceFormRequest;
use App\Device;
use App\Indicator;

use GuzzleHttp\Client;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = Device::all();
        return view('device.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('device.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DeviceFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceFormRequest $request)
    {
        $device = new Device(
            array(
                'code' => $request->get('code'),
                'bat' => $request->get('bat'),
            )
        );
        $device->save();


        return redirect('/device')->with('status', 'Your device has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $device = $this->processApiRequest($code);

        $indicators = Indicator::where('device_id', $device->id)
            ->orderBy('time', 'asc')
            ->get();

        $result[] = ['Time', 'Pressure'];
        foreach ($indicators as $key => $value) {
            $result[++$key] = [date('d.m.Y h:i:s', $value->time), (float)$value->pressure];
        }

        return view('device.show', ['device' => $device, 'indicators' => json_encode($result)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $device = Device::whereCode($code)->firstOrFail();
        return view('device.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $code
     * @param  \App\Http\Requests\DeviceFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($code, DeviceFormRequest $request)
    {
        $device = Device::whereCode($code)->firstOrFail();
        $device->code = $request->get('code');
        $device->bat = $request->get('bat');
        $device->save();

        return redirect(action('Web\DeviceController@edit', $device->code))->with('status', 'The device '. $code .' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        $device = Device::whereCode($code)->firstOrFail();
        $device->delete();
        return redirect('/devices')->with('status', 'The device '. $code .' has been deleted!');
    }

    /**
     * @param string $code
     * @return \App\Device
     */
    private function processApiRequest($code)
    {
        $url =  $this->getDeviceDataApiUrl($code);
        $client = new Client([
            // You can set any number of default request options.
            'timeout'  => 5.0,
        ]);
        $response = $client->request('GET', $url);

        $deviceData = json_decode($response->getBody()->getContents());
        $device = Device::whereCode($code)->firstOrFail();
        $device->bat = $deviceData->bat;
        $device->save();

        foreach ($deviceData->data as $indicatorData) {
            $indicator = new Indicator();
            $indicator->time = $indicatorData->timestamp;
            $indicator->pressure = $indicatorData->pressure;
            $indicator->device_id = $device->id;
            $indicator->save();
        }

        return $device;
    }

    /**
     * @param $code
     * @return string
     */
    private function getDeviceDataApiUrl($code)
    {
        $url =  action('Api\DeviceController@show', $code);

        return $url;
    }
}