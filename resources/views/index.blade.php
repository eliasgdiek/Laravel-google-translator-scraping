@extends('layout')
@section('styles')
<style>

</style>
@endsection
@section('content')
<div id="top">
<div id="main">
    <div class="wrapper">
        <div class="head text-center">
            <h1>Welcome to here!</h1>
        </div>
        <br />
        <form action="/get" method="post" enctype="multipart/form-data">
        @csrf
            <h5>From CSV file:</h5>
            <input type="file" class="form-control" id="csv" name="csv" required />
            <br />
            <button type="submit" class="form-control btn btn-danger">Scraping Now!</button>
        </form>
    </div>
</div>
</div>
<br /><br /><br />
@endsection
@section('scripts')
@endsection