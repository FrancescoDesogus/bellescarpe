<script type="text/javascript">
    $(function(){
      //$('.error').hide();
        $('.btn-lg').prop('disabled', true);

        $('input').keyup(function(){
            validate($('#user').val(), $('#passw').val());
        });

        function validate(username, passw){
          var regexp;
          regexp = new RegExp("^\s*[0-9a-zA-Z][0-9a-zA-Z ]*$");

          var match_user = regexp.test(username);
          var match_passw = regexp.test(passw);

          if(match_user){
                $('#user').removeClass("input-error");
            $('#user').addClass("input-success");
          }
          else{
            $('#user').addClass("input-error");
            $('#user').removeClass("input-success");
          }

          if(match_passw){
                $('#passw').removeClass("input-error");
            $('#passw').addClass("input-success");
          }
          else{
            $('#passw').addClass("input-error");
            $('#passw').removeClass("input-success");
          }

          $('.btn-lg').prop('disabled', !(match_user && match_passw));
        }
    });
</script>