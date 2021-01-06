<?php
    require_once "config.php";
    // Define variables and initialize with empty values
    $email = $password = $confirm_password = "";
    $email_err = $password_err = $confirm_password_err = "";
    $gender = $skills = $value = $address = "";
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        echo "brk1";
        // Validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter a email.";
            echo "brk2";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $emailErr = "Invalid email format";
            echo "brk3";
        }
        else{
        //     echo "brk34";
        //     // Prepare a select statement
        //     $sql = "SELECT id FROM user WHERE email = ?";
        //     echo "brk4";
            
        //     if($stmt = mysqli_prepare($con, $sql)){
        //         // Bind variables to the prepared statement as parameters
        //         mysqli_stmt_bind_param($stmt, "s", $param_email);
                
        //         // Set parameters
        //         $param_email = trim($_POST["email"]);
        //         echo "brk5";
                
        //         // Attempt to execute the prepared statement
        //         if(mysqli_stmt_execute($stmt))
        //         {
        //             /* store result */
        //             mysqli_stmt_store_result($stmt);
                    
        //             if(mysqli_stmt_num_rows($stmt) == 1)
        //             {
        //                 $email_err = "This email is already taken.";
        //                 echo "brk6";
        //             } 
        //             else
        //             {
        //                 $email = trim($_POST["email"]);
        //                 echo "brk7";
        //             }
        //         }
                // else
                // {
                    echo "Oops! Something went wrong. Please try again later.";
                // }

                // Close statement
                mysqli_stmt_close($stmt);
                echo "brk8";
        }
        
        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";
            echo "brk9";
        } 
        elseif((preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)))
        {
            $password_err = "Password must be between 8 character, atleast one small letter, one capital letter 
            and a special character.";
            echo "brk10";
        }
            else{
            $password = trim($_POST["password"]);
            echo "brk11";
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";
            echo "brk12";    
        }
        else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
            echo "brk13";
        }
        
        // Check input errors before inserting in database
        if(empty($email_err) && empty($password_err) && empty($confirm_password_err))
        {
            // Collect post variables
            $gender = $_POST['gender'];
            $skills = $_POST['skills'];
            $value = implode(",",$skills);
            $address = $_POST['address'];
            // Prepare an insert statement
            $sql = "INSERT INTO `user` (`email`, `password`, `confirm_password`, `gender`, `skills`,`address`, `dd`)
            VALUES ('$email', '$password', '$confirm_password', '$gender', '$value', '$address', current_timestamp());";
            
            // INSERT INTO `user` (`slno`, `email`, `password`, `confirm_password`, `gender`, `skills`, `address`, `dd`) 
            // VALUES ('1', 'abc@gmail.com', 'abc#456S', 'abc#456S', 'female', 'java, c, c++', 'Kolkata', current_timestamp());

            echo "brk14";

            if($stmt = mysqli_prepare($con, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
                echo "brk15";
                
                // Set parameters
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                echo "brk16";
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    header("location: login.php");
                } else{
                    echo "Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        // Close connection
        mysqli_close($con);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to registration form for Techmonastic Solutions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h3>Welcome to Techmonastic Solutions</h3>
        <h4>This is the registration form.</h4>
        <p>Enter your details and submit the form for further process: </p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="text_element">
                <label>Email: <input type="text" name="email" id="email" ></label>
                <label for="pwd">Password: </label><input type="password" name="password" id="pwd" >
                <label for="conf_pwd">Confirm Password: </label><input type="password" name="confirm_password" id="confpwd" >
            </div>
            <div class="check_box">
                <label for="m">Male <input type="radio" name="gender" id="male"></label>
                <label for="f">Female <input type="radio" name="gender" id="female"> </label>
                <label for="f">Others <input type="radio" name="gender" id="others"> </label>
            </div>
            <div class="check_box">
                <label>
                    Check the skill(s) applicable
                </label>
                <input type="checkbox" name="skills[]" value="C"> C
                <input type="checkbox" name="skills[]" value="C++"> C++
                <input type="checkbox" name="skills[]" value="Java"> Java
                <input type="checkbox" name="skills[]" value="PhP"> PhP
                <input type="checkbox" name="skills[]" value="Python"> Python
            </div>
            <div class="district">
                <label>
                    Select your address: 
                    <select name="address">
                        <option selected disabled>--Select District--</option>
                        <option>Alipurduar</option>
                        <option>Bankura</option>
                        <option>Birbhum</option>
                        <option>Cooch Behar</option>
                        <option>Dakshin Dinajpur</option>
                        <option>Darjeeling</option>
                        <option>Hoogly</option>
                        <option>Howrah</option>
                        <option>Jalpaiguri</option>
                        <option>Jhargram</option>
                        <option>Kalimpong</option>
                        <option>Kolkata</option>
                        <option>Maldah</option>
                        <option>Murshidabad</option>
                        <option>Nadia</option>
                        <option>North 24 Parganas</option>
                        <option>Paschim Bardhamann</option>
                        <option>Paschim Medinipur</option>
                        <option>Purba Bardhamann</option>
                        <option>Purba Medinipur</option>
                        <option>Purulia</option>
                        <option>South 24 Parganas</option>
                        <option>Uttar Dinajpur</option>
                    </select>
                </label>
            </div>
            <button class="btn">submit</button>
        </form>
    </div>
    <script src="index.js"></script>
</body>
</html>