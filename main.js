var s_name = 0;
var s_email = 0;
var s_password = 0;
var s_confirm_password=0;
$(".sign_up").click(function(){
  $(".signup_Form").css("display", "block");
  $("#login_Form,.forgot_password_Form ").css("display", "none");
});
$(".sign_in").click(function(){
  $(".signup_Form,.forgot_password_Form").css("display", "none");
  $("#login_Form").css("display", "block");
});
$(".forgot_password").click(function(){
  $(".forgot_password_Form").css("display", "block");
  $("#login_Form,.signup_Form").css("display", "none");
});
// this.validation_check();
 
  function namevalidation(){
    var regex_name = /^[a-zA-Z'\s]{1,40}$/;
    if(regex_name.test($('#s_full_name').val())){
         s_name=1;
         $('#error_full_name').html('');
         validation_check();
        }else{
          s_name=0;
          $('#error_full_name').html('please enter full name');
          validation_check();

    }
  }
  


  function semailvalidation(){
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(regex.test($('#s_email').val())){
      s_email=1;
         $('#error_s_email').html('');

         this.validation_check();
        }else{
          s_email=0;
        $('#error_s_email').html('please enter valid email');

        this.validation_check();
    }
  }

  
  function spasswordvalidation(){
      if($('#s_password').val().length<5){
        s_password=0;
        $('#error_s_password').html('Password length should be 5 or more');
        this.validation_check();
       }else{
      s_password=1;
      $('#error_s_password').html('');
      this.validation_check();

    }
  }
  function confirmpasswordvalidation(){
    if($('#confirm_password').val()===$('#s_password').val()){
      s_confirm_password=1;
    $('#error_confirm_password').html('');
   this.validation_check();
    this.validation_check();
       }else{
        s_confirm_password=0;
      $('#error_confirm_password').html('Password does not matched');
      this.validation_check();
    }
  }
  function validation_check(){
    if(s_name && s_email && s_password && s_confirm_password){
    $('#signup_validation').attr('disabled', false);
    console.log("disabled false");
    }else{
    $('#signup_validation').attr('disabled', true);
    console.log("disabled true");
   }
  }
  $('#submit_signup_form').submit(function(e){
    e.preventDefault();
   $.ajax({
       url: 'user_signup',
       data:$('#submit_signup_form').serialize(),
       type:'post',
       success:function(result){
         console.log(result);
    $('#signup_validation').attr('disabled', true);

         $("#register_success").css("display", "block");
         $("#register_success").html(result.msg);
      $('#submit_signup_form')['0'].reset();
    $('#signup_validation').attr('disabled', true);
 
       }
    })
  
  })


  function lemailvalidation(){
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(regex.test($('#l_email').val())){
         $('#error_l_email').html('');

        }else{
        $('#error_l_email').html('please enter valid email');

    }
  }
  function lpasswordvalidation(){
      if($('#l_password').val().length<1){
        $('#error_l_password').html('Please enter password');
       }else{
      $('#error_l_password').html('');

    }
  }


  $('#submit_login_Form').submit(function(e){
    e.preventDefault();
   $.ajax({
       url: 'user_login_process',
       data:$('#submit_login_Form').serialize(),
       type:'post',
       success:function(result){
         console.log(result);
         if(result.status=="success"){
           window.location.href='user/dashboard';
         }
         $("#login_msg").css("display", "block");
         $("#login_msg").html(result.msg);
        $('#submit_login_Form')['0'].reset();
       }
    })
  })
  
  
    

    function user_name(){
      var user_name = /^[a-zA-Z'\s]{1,40}$/;
      if(user_name.test($('#name').val())){
           $('#error_name').html('');
          }else{
            $('#error_name').html('Please enter full name');
      }
    }
     
    
    function city_filter_handler(){
      // event.preventDefault();
      console.log($("#state").val());
      var satate_id = $("#state").val();

      console.log('xcvbnm');
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "getcity",
        type :'post',
        dataType : 'json',
        delay : 200,
        data:'state_id='+satate_id,
          success:function(result){
            console.log(result);
            $('#city_list').html(result);

          }
          
       })
      }