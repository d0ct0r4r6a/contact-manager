@include('layouts.partials.header')

{{-- NAVBAR --}}
@include('layouts.partials.navbar')

<div class="container-fluid">
  <div class="row">

    <!--SIDEBAR-->
    <div class="col-xs-3 col-xs-offset-1">
     <div class="list-group">
       <?php 
        $selected_group = Request::get('group_id');
        $listGroups = listGroups(Auth::user()->id);
       
       ?>

       <a href="{{ route('contacts.index') }}" class="list-group-item {{ empty($selected_group) ? 'active' : '' }}">All Contacts 
        <span class="badge">
          {{--{{ App\Contact::count() }}--}} 
          {{collect($listGroups)->sum('total')}}
        </span>
       </a>
       
       
       @foreach ($listGroups as $group)
        <a href="{{ route('contacts.index', ['group_id' => $group->id]) }}" class="list-group-item {{ $selected_group==$group->id ? 'active' : '' }}">{{ $group->name }} <span class="badge">{{$group->total}} </span></a>
       @endforeach
     </div>
    </div>

    <!--DYNAMIC CONTENT-->
    <div class="col-xs-7">
      @if (session('message'))
        <div class="alert alert-success">
          {{session('message')}}
        </div>
      @endif
      @yield('content')
    </div>
    
  </div>
</div>


<!--SCRIPT-->
@include('layouts.partials.footer')