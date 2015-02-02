You recently requested the parsing of text data using the Parse Text Data command. Below are the results of the processed files:
<br /><br />
@foreach($outputs as $type => $output)
    <strong>{{$type}}</strong><br />
    {{$output}}<br /><br />
@endforeach