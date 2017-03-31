@extends('layouts.main')

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <div class="pull-left">
      <?php $selected_group = Request::get('group_id') ;
        $group = $selected_group ? App\Group::all()[$selected_group-1]->name : "All Contacts";
      ?>
        <h3 style="line-height:0px;">{{ $group }}</h3>
      </div>
      <div class="pull-right">
        <a href="{{ route("contacts.create")}} "class="btn btn-success navbar-btn"><i class="glyphicon glyphicon-plus"></i> Add Contact</a>
      </div>
    </div>
        
    @foreach ($contacts as $contact)
    <div class="panel-body">
      <div class="col-xs-2">
        <img src="http://placehold.it/100x100">
      </div>
      <div class="col-xs-9">
        <h4 class="media-heading">{{ $contact->name }}</h2>
        <p><strong>{{ $contact->company }}</strong></p>
        <p>{{ $contact->email }}</p>
      </div>
      <div class="col-xs-1">
        {!! Form::open(['method' => 'DELETE', 'route' => ['contacts.destroy',$contact->id]])!!}
        <a href="{{ route("contacts.edit",['id' => $contact->id])}}" class="btn btn-primary btn-xs" title="Edit">
          <i class="glyphicon glyphicon-edit"></i>
        </a>
        <button onclick="return confirm('Are you sure?')" href="#" class="btn btn-danger btn-xs" title="Delete">
          <i class="glyphicon glyphicon-remove"></i>
        </button>
        {!! Form::close()!!}
      </div>
    </div>
    @endforeach
  </div>

  <!--PAGINATION-->
    <nav aria-label="Page navigation" style="text-align: center;">
      {!! $contacts->appends( Request::query() )->render()!!}
    </nav>
@endsection

@section('test')

  <h1>Hello World!</h1>

@endsection