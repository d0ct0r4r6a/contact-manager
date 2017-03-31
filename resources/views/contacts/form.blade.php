<div class="panel-body container-fluid">
  <div class="form-horizontal">
    <div class="row">
      <div class="col-xs-8">
        
        @if (count($errors))
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Name</label>
          <div class="col-xs-10">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="company" class="col-sm-2 control-label">Company</label>
          <div class="col-xs-10">
            {!! Form::text('company', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>
          <div class="col-xs-10">
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="phone" class="col-sm-2 control-label">Phone</label>
          <div class="col-xs-10">
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="col-sm-2 control-label">Address</label>
          <div class="col-xs-10">
            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 2]) !!}
          </div>
        </div>
        <div class="form-group">
          <label for="group" class="col-sm-2 control-label">Group</label>
          <div class="col-xs-7">
            {!! Form::select('group_id', App\Group::pluck('name','id'), null, ['class' => 'form-control']) !!}
          </div>
          
          <div class="col-xs-3">
            <a href="#" class="btn btn-default" type="button" id="add-group-btn">Add Group</a>
          </div>  
        </div>
        <div class="form-group">
          <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
        </div>

        
        {{-- ADD NEW GROUP INPUT --}}
        <div id="add-new-group">
          <div class="col-xs-offset-2 input-group">
            <input class="form-control" type="text" id="new_group">
            <span class="input-group-btn">
              <button id="add-new-btn" class="btn btn-primary" type="button">Add</button>
            </span>
          </div>
        </div>


      </div>
      {{-- TODO: Fix (Refactor) form layout to accomodate photo --}}
      <div class="col-xs-3 col-xs-offset-1">
        <img src="" alt="..." style="max-width: 200px; max-height: 150px;">
        <div class="clearfix"></div>
        {!! Form::file('photo')!!}
        
      </div>
    </div>
  </div>
</div>
<div class="panel-footer">
  <button class="btn btn-success">{{ !empty($contact->id) ? 'Update' : 'Save'}}</button>
  <button class="btn" type="button" onclick="window.history.back();">Cancel</button>
</div>

@section('form-script')
  <script>
  $("#add-new-group").hide();
  $("#add-group-btn").click(function(){
    $("#add-new-group").slideToggle(function(){
      $("#new_group").focus();
    });
    return false;
  });
  

  $("#add-new-btn").click(function(){
    var $inputGroup = $("#new_group")
                        .closest('.input-group');
    $.ajax({
      url: "{{ route("groups.store") }}",
      method: 'post',
      data: {
        name: $("#new_group").val(),
        _token: "{{ csrf_token() }}"
      },
      success: function(group){
        if (group.id != null){
          $inputGroup.removeClass('has-error');
          $inputGroup.next('.text-danger').remove();

          var newOption = $('<option></option>')
              .attr("value", group.id)
              .attr("selected", true)
              .text(group.name);

          $("select[name=group_id]")
            .append(newOption);
          
          $("#new_group").val("");
        }
      },
      error: function(xhr){
        $("#new_group").focus();
        
        var errors = xhr.responseJSON;
        var error = errors.name[0];
        if (error) {
          $inputGroup.next('.text-danger').remove();
          $inputGroup
            .addClass('has-error')
            .after('<p class="col-xs-offset-2 text-danger">'
              + error
              + '</p>')
        }
      }
    });
  });
  </script>
@endsection
