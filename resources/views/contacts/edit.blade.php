@extends('layouts.main')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><strong>Edit Contact</strong></h3>
  </div>
  {!! Form::model($contact, ['files' => true, 'route'=>['contacts.update', $contact->id], 'method' => 'PATCH']) !!}
  @include("contacts.form")
  {!! Form::close() !!}
</div>
@endsection