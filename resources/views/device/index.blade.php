@extends('master')
@section('title', 'View all devices')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2> Devices </h2>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            @if ($devices->isEmpty())
                <p> There is no device.</p>
            @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Bat</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td>{!! $device->id !!} </td>
                            <td><a href="{!! action('Web\DeviceController@show', $device->code) !!}">{!! $device->code !!}</a></td>
                            <td>{!! $device->bat !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection