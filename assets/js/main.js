 /* user register js  */

$(document).ready(function() {
  $("#registerForm").submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
      url: 'function/user_register.php', // your PHP handler
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        try {
          var responseData = JSON.parse(response);

          const toast = new bootstrap.Toast(document.getElementById("toastMessage"));

          if (responseData.status == 1) {
            $("#toastMessage").removeClass("bg-danger").addClass("bg-success");
            $("#toastBody").text(responseData.msg);
            toast.show();
            $("#registerForm")[0].reset();
          } else {
            $("#toastMessage").removeClass("bg-success").addClass("bg-danger");
            $("#toastBody").text(responseData.msg || "Something went wrong.");
            toast.show();
            setTimeout(() => {
                window.location.href = "login.php"; // redirect on success
              }, 1500);
          }

        } catch (e) {
          $("#toastMessage").removeClass("bg-success").addClass("bg-danger");
          $("#toastBody").text("Invalid response.");
          const toast = new bootstrap.Toast(document.getElementById("toastMessage"));
          toast.show();
        }
      },
      error: function() {
        $("#toastMessage").removeClass("bg-success").addClass("bg-danger");
        $("#toastBody").text("Request failed. Please try again.");
        const toast = new bootstrap.Toast(document.getElementById("toastMessage"));
        toast.show();
      }
    });
  });
});


/*  login js start */
$(document).ready(function() {
    $('#loginForm').submit(function(e) {
      e.preventDefault();
  
      $.ajax({
        url: 'function/user_login.php', // same file
        method: 'POST',
        data: {
          email: $('#email').val(),
          password: $('#password').val()
        },
        success: function(response) {
          const res = JSON.parse(response);
          const toast = new bootstrap.Toast(document.getElementById("toastLogin"));
  
          if (res.status == 1) {
            $('#toastLogin').removeClass('bg-danger').addClass('bg-success');
            $('#toastLoginBody').text(res.msg);
            toast.show();
            setTimeout(() => {
              window.location.href = "admin/dashboard.php"; // redirect on success
            }, 1500);
          } else {
            $('#toastLogin').removeClass('bg-success').addClass('bg-danger');
            $('#toastLoginBody').text(res.msg);
            toast.show();
          }
        },
        error: function() {
          $('#toastLogin').removeClass('bg-success').addClass('bg-danger');
          $('#toastLoginBody').text("Request failed.");
          const toast = new bootstrap.Toast(document.getElementById("toastLogin"));
          toast.show();
        }
      });
    });
  });