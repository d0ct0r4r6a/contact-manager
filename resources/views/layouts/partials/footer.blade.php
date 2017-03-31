<script src="{{ URL::to('js/app.js') }}"></script>
<script src="{{ URL::to('js/jquery-ui.min.js') }}"></script>
<script>
  $(function(){
    $("input[name=term]").autocomplete({
      source: "{{ route("contacts.autocomplete")}}",
      minLength: 3,
      select: function(event, ui){
        $(this).val(ui.item.value);
      }
    });
  });
</script>
@yield('form-script')
</body>
</html>