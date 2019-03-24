@extends('layouts.app')

@section('content')

    <form action="{{action('GraphController@graph')}}" onchange="this.submit()">
        <input type="text" name="daterange" value="{{$date->format('Y-m-d')}}" />
    </form>
    <div class="container" style="width: 100%; min-height: 300px; max-height: 80%">
        <div class="row">
            <div class="col-12">
                <canvas id="graph"></canvas>
            </div>
        </div>
    </div>

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
                        }],
                        yAxes: [{
                            ticks: {
                                // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                                suggestedMin: 0,

                                // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                                suggestedMax: 20
                            }
                        }]
                    }
                }

            });
        }, 1000);
    </script>

@endsection