<?php
//include("nav.php");
$first_name = $middle_name = $last_name = $gender = $prefix = $seven_digit = $email = "";
$first_nameErr = $middle_nameErr = $last_nameErr = $genderErr = $prefixErr = $seven_digitErr = $emailErr = "";

if(isset($_POST["btn_register"])){
  if(empty($_POST["first_name"])){
      $first_nameErr = "Required!";
  }else{
      $first_name = $_POST["first_name"];
  }

  if(empty($_POST["middle_name"])){
      $middle_nameErr = "Required!";
  }else{
      $middle_name = $_POST["middle_name"];
  }

  if(empty($_POST["last_name"])){
    $last_nameErr = "Required!";
  }else{
    $last_name = $_POST["last_name"];
  }

  if(empty($_POST["gender"])){
    $genderErr = "Required!";
  }else{
    $gender = $_POST["gender"];
  }

  if(empty($_POST["prefix"])){
    $prefixErr = "Required!";
  }else{
    $prefix = $_POST["prefix"];
  }

  if(empty($_POST["seven_digit"])){
    $seven_digitErr = "Required!";
  }else{
    $seven_digit = $_POST["seven_digit"];
  }

  if(empty($_POST["email"])){
    $emailErr = "Required!";
  }else{
    $email = $_POST["email"];
  }

    if($first_name && $middle_name && $last_name && $gender && $prefix && $seven_digit && $email){
        if(!preg_match("/^[a-zA-Z ]*$/",$first_name)){
            $first_nameErr = "Letters and spaces only!";
        }else{
            $count_first_name_string = strlen($first_name);
            if($count_first_name_string < 2){
                $first_nameErr = "First name too short!";
            }else{
                $count_middle_name_string = strlen($middle_name);
                if($count_middle_name_string < 2){
                    $middle_nameErr = "Middle name too short!";
                }else{
                    $count_last_name_string = strlen($last_name);
                    if($count_last_name_string < 2){
                        $last_nameErr = "Last name too short!";
                    }else{
                        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                            $emailErr = "Invalid email format!";
                        }else{
                            $count_seven_digit_string = strlen($seven_digit);
                            if($count_seven_digit_string < 7){
                                $seven_digitErr = "Seven (7) digits required!";
                            }else{
                                function random_password( $length=5 ){
                                    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                                    $shuffled = substr(str_shuffle($str), 0, $length);
                                    return $shuffled;
                                }

                                $password = random_password(8);
                                include("connections.php");
                                mysqli_query($connections, "INSERT INTO tbl_user(`first_name`,`middle_name`,`last_name`,`gender`,`prefix`,`seven_digit`,`email`,`password`,`account_type`) VALUES(`$first_name`,`$middle_name`,`$last_name`,`$gender`,`$prefix`,`$seven_digit`,`$email`,`$password`,`2`) ");
                                
                                echo "
                                <br>
                                <br>
                                  <div class='modal modal-tour position-static d-block bg-secondary py-5' tabindex='-1' role='dialog' id='modalTour'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content rounded-4 shadow'>
                                      <div class='modal-body p-5'>
                                        <h2 class='fw-bold mb-0'>You are all set, $first_name!</h2>
                                
                                        <ul class='d-grid gap-4 my-5 list-unstyled'>
                                        <li class='d-flex gap-4'>
                                          <img class='bi text-warning flex-shrink-0' width='48' height='48' src='./Photos/mail.png'>
                                          <div>
                                            <h5 class='mb-0'>Email</h5>
                                            Your email is $email
                                          </div>

                                        </li>
                                          <li class='d-flex gap-4'>
                                            <img class='bi text-warning flex-shrink-0' width='48' height='48'src='./Photos/padlock.png'>
                                            <div>
                                              <h5 class='mb-0'>Password</h5>
                                              Your password is $password
                                            </div>
                                          </li>
                                        </ul>
                                        <a class='btn btn-lg btn-success mt-5 w-100' data-bs-dismiss='modal' href='login'>Great, thanks!</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </div>";

                                }
                            }
                        }                                
                    }
                }
            }
        }
    }
?>

<style>
    .error{
        color:red;
    }
</style>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <title>Register</title>
</head>

<script type="application/javascript">
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode

        if(charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

<body class="">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand float-md-start mb-0" href="index">Code<span style="color:green">Snippet</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="nav nav-masthead justify-content-center float-md-end">
      <a class="btn btn-m btn-outline-success fw-bold border-white" aria-current="page" href="login">Login</a>
      <a class="btn btn-m btn-outline-light fw-bold border-white ms-1" aria-current="page" href="register">Register</a>
      </ul>
      </div>
    </div>
  </nav>


  <form method="POST">
    <section class="vh-100 gradient-custom">
      <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
          <div class="col-12 col-lg-9 col-xl-10">
                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 fw-bold">Register</h3>
                <form>

                  <div class="row">
                    <div class="col-md-6 mb-4">

                      <div class="form-outline">
                        <input type="text" name="first_name" class="form-control form-control-lg" value="<?php echo $first_name; ?>" ><span class="error"><?php echo $first_nameErr; ?></span>
                        <label class="form-label" for="first_name">First Name</label>
                      </div>

                    </div>
                    <div class="col-md-6 mb-4">

                      <div class="form-outline">
                        <input type="text" name="middle_name" class="form-control form-control-lg" value="<?php echo $middle_name; ?>" ><span class="error"><?php echo $middle_nameErr; ?></span>
                        <label class="form-label" for="middle_name">Middle Name</label>
                      </div>

                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4 d-flex align-items-center">

                      <div class="form-outline w-100">
                        <input type="text" name="last_name" class="form-control form-control-lg" value="<?php echo $last_name; ?>" ><span class="error"><?php echo $last_nameErr; ?></span>
                        <label for="last_name" class="form-label">Last Name</label>
                      </div>

                    </div>
                    <div class="col-md-6 mb-4" name="gender">

                      <h6 class="mb-2 pb-1">Gender: </h6>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Female" id="Female" <?php if($gender == "Female") {echo "selected";} ?> ><span class="error"><?php echo $genderErr; ?></span>
                        <label class="form-check-label" for="Female">Female</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Male" id="Male" <?php if($gender == "Male") {echo "selected";} ?> ><span class="error"><?php echo $genderErr; ?></span>
                        <label class="form-check-label" for="Male">Male</label>
                      </div>

                    </div>
                  </div>


                    <div class="row">
                    <div class="col-6">

                      <select class="form-select form-select-lg mb-2" name="prefix" id="prefix">
                        <option name="prefix" id="prefix" disabled>--Choose prefix--</option>
                        <option name="prefix" id="prefix" value="0917" <?php if($prefix == "0917") {echo "selected"; } ?>>0917</option>
                        <option name="prefix" id="prefix" value="0919" <?php if($prefix == "0919") {echo "selected"; } ?>>0919</option>
                        <option name="prefix" id="prefix" value="0956" <?php if($prefix == "0956") {echo "selected"; } ?>>0956</option>
                        <option name="prefix" id="prefix" value="0945" <?php if($prefix == "0945") {echo "selected"; } ?>>0945</option>
                        <option name="prefix" id="prefix" value="0923" <?php if($prefix == "0923") {echo "selected"; } ?>>0923</option>
                      </select><span class="error is-invalid"><?php echo $prefixErr; ?></span>
                      <label class="form-label select-label">Network Prefix</label>

                    </div>
                  
                    <div class="col-md-6 mb-2">

                      <div class="form-outline">
                        <input type="text" name="seven_digit" value="<?php echo $seven_digit; ?>" maxlength="7" onkeypress='return isNumberKey(event)' class="form-control form-control-lg"><span class="error is-invalid"><?php echo $seven_digitErr; ?></span>
                        <label class="form-label" for="seven_digit">Other Seven Digit</label>
                      </div>

                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6 mt-4 mb-6 pb-2">

                      <div class="form-outline">
                        <input type="text" class="form-control form-control-lg" name="email" value="<?php echo $email; ?>" ><span class="error is-invalid"><?php echo $emailErr; ?></span>
                        <label class="form-label" for="email">Email</label>
                      </div>

                  <div class="mt-4 pt-2">
                    <input class="btn btn-success btn-lg" name="btn_register" type="submit" value="Submit">
                  </div>


                </form>
              </div>

        </div>
      </div>
    </section>
  </form>

</body>

</html>

