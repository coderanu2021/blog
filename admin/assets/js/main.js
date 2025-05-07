 /* header */

 const profileIcon = document.getElementById('profileIcon');
  const profileDropdown = document.getElementById('profileDropdown');

  profileIcon.addEventListener('click', () => {
    profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
  });

  // Optional: Close dropdown if clicked outside
  document.addEventListener('click', function(e) {
    if (!profileIcon.contains(e.target)) {
      profileDropdown.style.display = 'none';
    }
  });

  ClassicEditor.create(document.querySelector('#metaShortDesc')).catch(error => console.error(error));
  ClassicEditor.create(document.querySelector('#longDesc')).catch(error => console.error(error));


  /*  js for add blog */
  $(document).ready(function() {
    $("#BLOG_ADD_FORM").submit(function(e) {
      e.preventDefault();
  
      var formData = new FormData(this);
  
      $.ajax({
        url: '../../function/add_post.php', // your PHP handler
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

    /*  js for add blog CATEGORY */
    $(document).ready(function() {
      $("#ADD_CATEGORY").submit(function(e) {
        e.preventDefault();
    
        var formData = new FormData(this);
    
        $.ajax({
          url: '../../function/add_category.php', // your PHP handler
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