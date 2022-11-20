<!-- PHP CODE SECTION ABOVE -->
<!DOCTYPE html>
<html lang='en'>

<head>
  <!-- Head section -->
  <?php include ( './includes/head.php' );
?>

  <title>Membership</title>
</head>

<body>
  <!-- Admin Navbar section -->
  <?php include ( './includes/globalNavbar.php' );
?>



  <section class='container py-2 mb-6 custom_main_register_form_container'>
    <div class='row'>
      <div class='col offset-sm-3 col-sm-6' style='min-height:500px;'>
        <br><br><br>
        <?php
// echo ErrorMessage();
// echo SuccessMessage();
?>
        <div class='card text-white border-0 global_login_register_form_box' style='background:#17a2b8;'>
          <div class='card-header'>
            <h5 class="text-center">Writer's Membership Form</h5>
            <p class="text-center">Do you want to join us?</p>
          </div>
          <div class='card-body bg-white custom_member_form_box'>
            <form class='' action='' method='POST'>
              <div class='form-group'>
                <label for='fullname'><span class='FieldInfo text-info'>Fullname:</span></label>
                <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                    <span class='input-group-text text-white bg-info'> <i class='fas fa-user'></i> </span>
                  </div>
                  <input type='text' class='form-control' name='fullname' id='fullname' autocomplete='off' value=''
                    required>
                </div>
              </div>
              <div class='form-group'>
                <label for='email'><span class='FieldInfo text-info'>Email address:</span></label>
                <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                    <span class='input-group-text text-white bg-info'> <i class='fa fa-envelope' aria-hidden='true'></i>
                    </span>
                  </div>
                  <input type='email' class='form-control' name='Email' id='email' autocomplete='off' value='' required>
                </div>
              </div>
              <div class='form-group'>
                <label for='message'><span class='FieldInfo text-info'>Message:</span></label>
                <div class='input-group mb-3'>

                  <textarea name='message' class='form-control' name='message' id='message' autocomplete='off' cols="15"
                    rows="6" required></textarea>
                </div>
              </div>
              <input type='submit' name='memberShipForm' class='btn btn-info btn-block global_btn_margin_top'
                value='Join Us'>
            </form>
          </div>

        </div>

      </div>

    </div>

  </section>



  <!-- Footer section -->
  <?php include ( './includes/footer.php' );
?>