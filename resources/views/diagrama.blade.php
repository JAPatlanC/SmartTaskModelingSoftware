@extends('layout')

@section('title', 'Diagrama')


@section('content')
<script>


    $( document ).ready(function() {
        var data = {!! json_encode($data) !!};
        var simple_chart_config = {
            chart: {
                container: "#tree-simple"
            },

            nodeStructure: data
        }
        console.log(simple_chart_config);
        var chart = new Treant(simple_chart_config, function() { console.log( 'Tree Loaded' ) }, $ );
    });
    /*
    $( document ).ready(function() {
        simple_chart_config = {
            chart: {
                container: "#tree-simple"
            },

            nodeStructure: {
                text: { name: "Parent node" },
                children: [
                    {
                        text: { name: "First child" },
                        children: [
                            {
                                text: { name: "First child 2" }
                            }
                    ]
                    },
                    {
                        text: { name: "Second child" }
                    }
                ]
            }
        };
        var chart = new Treant(simple_chart_config, function() { console.log( 'Tree Loaded' ) }, $ );
    });*/
</script>

    <h1>Diagrama actual</h1>

    <div id="tree-simple" style="width:1000px;" > </div>

@stop


