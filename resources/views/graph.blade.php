@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-12" style="position: relative;">
                <form action="{{action('GraphController@graph')}}" onchange="this.submit()" class="data-select-form">
                    <a href="#" onclick="$('[name=daterange]').val('{{$date->addDay(-1)->format('Y-m-d')}}').trigger('change');">&laquo;</a>
                    <input type="text" name="daterange" value="{{$date->format('Y-m-d')}}" autocomplete="off" />
                    <a href="#" onclick="$('[name=daterange]').val('{{$date->addDay(1)->format('Y-m-d')}}').trigger('change');">&raquo;</a>
                </form>
                <div class="graph-container" style="width: 100%; min-height: 250px; max-height: 70%">
                    <canvas id="graph"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        setTimeout(function() {

            var ctx = document.getElementById('graph').getContext("2d");

            var data = [];

            data = {!! json_encode(collect($lines)->map(function($line){
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