@extends('layouts.app')

@section('content')
    <form action="{{action('GraphController@upload')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="file" />
        <input type="submit" />
    </form>
@endsection