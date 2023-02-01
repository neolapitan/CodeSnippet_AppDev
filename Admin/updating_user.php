<?php

    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];

        $authentication = mysqli_query($connections, "SELECT * FROM tbl_user WHERE email='$email' ");
        $fetch = mysqli_fetch_assoc($authentication);
        $account_type = $fetch["account_type"];

        if($account_type != 1){
            echo "<script>window.location.href='../forbidden';</script>";
        }
    }

    $id_user = $_GET["id_user"];

    $get_record = mysqli_query($connections, "SELECT * FROM tbl_user WHERE id_user='$id_user' ");

    while($get = mysqli_fetch_assoc($get_record)){
        $db_first_name = $get["first_name"];
        $db_middle_name = $get["middle_name"];
        $db_last_name = $get["last_name"];

        $db_gender = $get["gender"];

        $db_prefix = $get["prefix"];
        $db_seven_digit = $get["seven_digit"];
        $db_email = $get["email"];
        $db_password = $get["password"];
    }

    $new_first_name = $new_middle_name = $new_last_name = $new_gender = $new_prefix = $new_seven_digit = $new_email = "";
    $new_first_nameErr = $new_middle_nameErr = $new_last_nameErr = $new_genderErr = $new_prefixErr = $new_seven_digitErr = $new_emailErr = "";

    if(isset($_POST["btn_update"])){
        if(empty($_POST["new_first_name"])){
            $new_first_nameErr = "This field must not be empty!";
        }else{
            $new_first_name = $_POST["new_first_name"];
            $db_first_name = $new_first_name;
        }

        if(empty($_POST["new_middle_name"])){
            $new_middle_nameErr = "This field must not be empty!";
        }else{
            $new_middle_name = $_POST["new_middle_name"];
            $db_middle_name = $new_middle_name;
        }

        if(empty($_POST["new_last_name"])){
            $new_last_nameErr = "This field must not be empty!";
        }else{
            $new_last_name = $_POST["new_last_name"];
            $db_last_name = $new_last_name;
        }

        if(empty($_POST["new_seven_digit"])){
            $new_seven_digitErr = "This field must not be empty!";
        }else{
            $new_seven_digit = $_POST["new_seven_digit"];
            $db_seven_digit = $new_seven_digit;
        }

        if(empty($_POST["new_email"])){
            $new_emailErr = "This field must not be empty!";
        }else{
            $new_email = $_POST["new_email"];
            $db_email= $new_email;
        }

        $db_gender = $_POST["new_gender"];
        $db_prefix = $_POST["new_prefix"];

        

        if($new_first_name && $new_middle_name && $new_last_name && $new_seven_digit && $new_email){
            if(!preg_match("/^[a-zA-Z ]*$/",$new_first_name)){
                $new_first_nameErr = "Letters and spaces only!";
            }else{
                $count_first_name_string = strlen($new_first_name);
                if($count_first_name_string < 2){
                    $new_first_nameErr = "First name too short!";
                }else{
                    $count_middle_name_string = strlen($new_middle_name);
                    if($count_middle_name_string < 2){
                        $new_middle_nameErr = "Middle name too short!";
                    }else{
                        $count_last_name_string = strlen($new_last_name);
                        if($count_last_name_string < 2){
                            $new_last_nameErr = "Last name too short!";
                        }else{
                            if(!filter_var($new_email, FILTER_VALIDATE_EMAIL)){
                                $new_emailErr = "Invalid email format!";
                            }else{
                                $count_seven_digit_string = strlen($new_seven_digit);
                                if($count_seven_digit_string < 7){
                                    $new_seven_digitErr = "Seven (7) digits required!";
                                } else{
                                    mysqli_query($connections, "UPDATE tbl_user SET
            
                                    first_name = '$db_first_name' ,
                                    middle_name = '$db_middle_name' ,
                                    last_name = '$db_last_name' ,
                                    gender = '$db_gender' ,
                                    prefix = '$db_prefix' ,
                                    seven_digit = '$db_seven_digit' ,
            
                                    email = '$db_email' WHERE id_user='$id_user' ");

                                    $encrypted = md5(rand(1,9));
                                    echo "<script>window.location.href='view_record?$encrypted&&notify=Record has been updated!'</script>";
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

<script type="application/javascript">
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode

        if(charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a id="liveToastBtn" class="navbar-brand float-md-start mb-0" href="#">Code<span style="color:green">Snippet</span></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="view_record">View Records</a>
            </li>
            </ul>
            <div class="nav nav-masthead justify-content-center float-md-end">
            <a class="btn btn-m btn-danger fw-bold ms-1" aria-current="page" href="../logout">Logout</a>
            </ul>
            </div>
        </div>
    </nav>

    <center>
    <br>
    <br>
    <br>
    <form method="POST">
        <table class="position-absolute top-50 start-50 translate-middle" boder="0" width="50%">
            
            <tr>
                <td><input class="form-control lg" type="text" name="new_first_name" value="<?php echo $db_first_name; ?>"><span class="error"><?php echo $new_first_nameErr; ?></span></td>
            </tr>

            <tr>
                <td><input class="form-control lg" type="text" name="new_middle_name" value="<?php echo $db_middle_name; ?>"><span class="error"><?php echo $new_middle_nameErr; ?></span></td>
            </tr>

            <tr>
                <td><input class="form-control lg" type="text" name="new_last_name" value="<?php echo $db_last_name; ?>"><span class="error"><?php echo $new_last_nameErr; ?></span></td>
            </tr>

            <tr>
                <td>
                    <select class="form-control lg" name="new_gender">
                        <option name="new_gender" value="Male" <?php if($db_gender == "Male") {echo "selected";} ?> >Male</option>
                        <option name="new_gender" value="Female" <?php if($db_gender == "Female") {echo "selected";} ?> >Female</option>
                    </select><span class="error"><?php echo $new_genderErr; ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <select class="form-control lg" name="new_prefix">
                        <option name="new_prefix" value="0917" <?php if($db_prefix == "0917") {echo "selected"; } ?> >0917</option>
                        <option name="new_prefix" value="0907" <?php if($db_prefix == "0907") {echo "selected"; } ?> >0907</option>
                        <option name="new_prefix" value="0944" <?php if($db_prefix == "0944") {echo "selected"; } ?> >0944</option>
                        <option name="new_prefix" value="0949" <?php if($db_prefix == "0949") {echo "selected"; } ?> >0949</option>
                        <option name="new_prefix" value="0956" <?php if($db_prefix == "0956") {echo "selected"; } ?> >0956</option>
                    </select><span class="error"><?php echo $new_prefixErr; ?></span>
                    &nbsp;
                    <input class="form-control lg" type="text" name="new_seven_digit" value="<?php echo $db_seven_digit; ?>" maxlength = 7 onkeypress='return isNumberKey(event)'><span class="error"><?php echo $new_seven_digitErr; ?></span>
                </td>
            </tr>

            <tr>
                <td>
                    <input class="form-control lg" type="text" name="new_email" value="<?php echo $db_email; ?>"><span class="error"><?php echo $new_emailErr; ?></span>
                </td>
            </tr>

            <tr>
                <td><br><br><input type="submit" name="btn_update" value="Update" class="btn btn-success"></td>
            </tr>
        </table>
    </form>
    </center>
   
</body>

</html>