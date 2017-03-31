@extends('layouts.main')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><strong>Add Contact</strong></h3>
  </div>
  {!! Form::open(['route'=>'contacts.store', 'files' => true]) !!}
  @include("contacts.form")
  {!! Form::close() !!}
</div>
@endsection