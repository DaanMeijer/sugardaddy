@extends('layouts.app')

@section('content')

    <form action="{{action('GraphController@graph')}}" onchange="this.submit()">
        <input type="text" name="daterange" value="{{$date->format('Y-m-d')}}" />
    </form>
    <canvas id="graph" style="width: 300px; height: 300px;"></canvas>

    <script type="text/javascript">

        setTimeout(function() {
            var ctx = document.getElementById('graph').getContext("2d");

            var data = {!! json_encode(collect($lines)->map(function($line){
                    return ['x' => $line->timestamp->timestamp * 1000, 'y' => $line->glucose];
            })) !!};

            // for(key in data){
            //     data[key].x = new Date(data[key].x);
            // }

            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets:[
                        {
                            label: "Glucose",
                            data: data
                        }
                    ],
                },
                options: {
                    scales: {
                        xAxes: [{
                            type: 'time',
                            time: {
                                displayFormats: {
                                    quarter: 'MMM YYYY'
                                },
                            }
                        }]
                    }
                }

            });
        }, 1000);
    </script>

@endsection