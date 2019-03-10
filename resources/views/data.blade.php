@extends('layout')
@section('styles')
@endsection
@section('content')
<br />
<div class="container" id="page-2">
    <h4 class="text-center">Success!</h4>
    @if(isset($count))
    <br />
    <p class="text-center">The scraping of {{$count}} words has been completed successfully.</p>
    <br />
    @endif
    @if(isset($path))
    <br />
    <p class="text-center">The CSV file is stored in {{$path}}</p>
    <br />
    @endif
</div>
<br />
<br />
<br />

@endsection
@section('scripts')
@endsection