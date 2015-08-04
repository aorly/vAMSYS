@extends('layouts.metronic')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
            Unparsed PIREP Lines
        </h3>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Unparsed Lines
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-hover table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Line
                                    </th>
                                    <th>
                                        ACARS
                                    </th>
                                    <th>
                                        PIREP
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lines as $line)
                                    <tr>
                                        <td>{{ $line->id }}</td>
                                        <td>{{ $line->line }}</td>
                                        <td>{{ $line->acars_id }}</td>
                                        <td>{{ $line->pirep_id }}</td>
                                        <td><a href="/admin/delete-unparsed-line/{{ $line->id }}" class="btn btn-danger btn-xs">Remove</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
