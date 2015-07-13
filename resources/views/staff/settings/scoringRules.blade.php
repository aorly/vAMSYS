@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Airline Scoring Rules <small>points mean prizes!</small>
        </h3>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Scoring Rules
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id='editor_holder'></div>
                        <button id='submit'>Submit (console.log)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('pagejs')
    <script>
        // This is the starting value for the editor
        // We will use this to seed the initial editor
        // and to provide a "Restore to Default" button.
        var starting_value = [
            {
                "scorer": "Engines\\Number2First",
                "name": "Engine 2 Started First",
                "points": 10
            },
            {
                "scorer": "Engines\\ShutdownBeforeSubmit",
                "name": "Engines Shutdown before PIREP Filed",
                "points": 10
            },
            {
                "scorer": "Landing\\Graduated",
                "name": "Landing",
                "thresholds": [
                    {
                        "name": "Perfect",
                        "lightest": -136,
                        "heaviest": -164,
                        "points": 40
                    },
                    {
                        "name": "Good",
                        "lightest": -110,
                        "heaviest": -135,
                        "points": 35,
                        "adjustment": {
                            "direction": "lighter",
                            "points": -1,
                            "from": -135
                        }
                    },
                    {
                        "name": "Good",
                        "lightest": -165,
                        "heaviest": -190,
                        "points": 35,
                        "adjustment": {
                            "direction": "heavier",
                            "points": -1,
                            "from": -165
                        }
                    },
                    {
                        "name": "Fair",
                        "lightest": -190,
                        "heaviest": -250,
                        "points": 10
                    },
                    {
                        "name": "Hard",
                        "lightest": -350,
                        "heaviest": -499,
                        "points": -10
                    },
                    {
                        "name": "Soft",
                        "lightest": 0,
                        "heaviest": -100,
                        "points": -10
                    },
                    {
                        "name": "Crash",
                        "lightest": -500,
                        "heaviest": -999999999999,
                        "points": -50
                    }
                ]
            }
        ]

        // Initialize the editor
        var editor = new JSONEditor(document.getElementById('editor_holder'),{
            // Enable fetching schemas via ajax
            ajax: true,
            theme: 'bootstrap3',
            iconlib: "fontawesome4",
            disable_edit_json: true,
            disable_collapse: true,
            // The schema for the editor
            schema: {
                type: "array",
                title: "Scoring Rules",
                format: "tabs",
                items: {
                    title: "Rule",
                    headerTemplate: "@{{i}} - @{{self.name}}",
                    oneOf: [
                        {
                            $ref: "/schemas/engines-number2first.json",
                            title: "Engines / Engine 2 Started First"
                        },
                        {
                            $ref: "/schemas/engines-shutdownBeforeSubmit.json",
                            title: "Engines / Shutdown Before Submit"
                        },
                        {
                            $ref: "/schemas/landing-graduated.json",
                            title: "Landing / Graduated"
                        }
                    ]
                }
            },

            // Seed the form with a starting value
            startval: starting_value,
            no_additional_properties: true

        });

        // Hook up the submit button to log to the console
        document.getElementById('submit').addEventListener('click',function() {
            // Get the value from the editor
            console.log(editor.getValue());
        });
    </script>
@stop
