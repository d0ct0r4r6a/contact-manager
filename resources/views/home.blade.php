@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="jumbotron text-center">
                <h1>Hello, {{ Auth::user()->name }}</h1>
                <p class="lead">
                    Welcome back to Contact Manager App
                </p>
                <p>
                <a href="{{ route("contacts.index") }}" class="btn btn-primary btn-lg">Manage your contacts</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
