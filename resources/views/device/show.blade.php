@extends('master')
@section('title', 'View a device')
@section('javascript_head')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var indicators = <?php echo $indicators; ?>;
        console.log(indicators);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(indicators);
            var options = {
                title: 'Indicator Line Chart',
                curveType: 'function',
                legend: { position: 'bottom' }
            };
            var chart = new google.visualization.LineChart(document.getElementById('linechart'));
            chart.draw(data, options);
        }
    </script>
@endsection

@section('content')



    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <div class="content">
                <h2 class="header">Devce code: {!! $device->code !!}</h2>
                <p> {!! $device->bat !!} </p>
            </div>
            <a href="{!! action('Web\DeviceController@edit', $device->code) !!}" class="btn btn-info pull-left">Edit</a>

            <form method="post" action="{!! action('Web\DeviceController@destroy', $device->code) !!}" class="pull-left">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div>
                    <button type="submit" class="btn btn-warning">Delete</button>
                </div>
            </form>

            <div class="clearfix"></div>
        </div>

        <div>
            <div id="linechart" style="width: 900px; height: 500px"></div>
        </div>
    </div>




@endsection