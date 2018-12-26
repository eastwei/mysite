        <?php

        // put your code here
        $page_title = 'Register';

        include ('include/header.html');

        //check for form submission:
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

             //Register the user in the database...
            require('../mysqli_connect.php'); //connect to the db.

            $errors = array(); //Initialize an error array.

        //Check for a first name:
        if (empty($_POST['first_name'])) {

            echo '<p> first_name is empty</p>';

            $errors[] = 'You forgot to enter your first name.';


        }else {

            $fn = mysqli_real_escape_string($dbc,trim($_POST['first_name']));
            
        }
	    
        //check for a last name:
        if (empty($_POST['last_name'])) {

            $errors[] = 'You forgot to enter your last name.';

        }else {

            $ln = mysqli_real_escape_string($dbc,trim($_POST['last_name']));
            
        }
        //Check for an email address:
        if(empty($_POST['email'])) {

            $errors[] = 'You forgot to enter you email address.';

        }else{

            $e = mysqli_real_escape_string($dbc,trim($_POST['email']));
           
        }
        //Check for a password and match against the confirmed password:
        if(!empty($_POST['pass1'])) {

            if($_POST['pass1'] != $_POST['pass2']) {

                $errors[] = 'Your password did not match the confirmed password.';

            }else{

                $p = mysqli_real_escape_string($dbc,trim($_POST['pass1']));
				echo "pass is $p";
            }
        }else {

            $errors[]='You forgot to enter your password.';
        } 
      
        if(empty($errors)) {//if everything's OK.
          
            //Make the query:
            $q = "INSERT INTO users(first_name,last_name,email,pass,"
                    . "registration_data)"
                    . "VALUES ('$fn','$ln','$e',SHA1('$p'),NOW())";
           
            $r = mysqli_query($dbc,$q); //Run the query.

            if ($r) { //if it ran ok.
                //Print a message:
                     echo '<h1> Thank you!</h1>'
                        . '<p> You are now registered. '
                        . 'In Chapter 12 you will actually'
                        . 'be able to log in! </p>'
                        . '<p> <br/></p>';
            }else { // if it did not run ok.
                //Public message:
                echo '<h1>System Error</h1>'
                     . '<p class="error"> You could not be '
                     . 'registered due to a system error.'
                     . 'We apologize for any inconveninece.</p>';
                //Debugging message:
                echo '<p>'. mysqli_error($dbc). 
                     '<br /><br />Query:' .$q.'</p>';
            }//End of if($r) IF.
                    
            mysqli_close($dbc); //Close the database connection.
            //Include the footer and quit the script:
	    //
            include ('include/footer.html');

            exit();

        }else { //Report the errors.
            echo '<h1>Error!</h1>'
            . '<p class="error">The following error(s) occurred:<br />';

            foreach ($errors as $msg) { //Print each error.

                echo "- $msg<br />\n";

            }

            echo '</p><p>Please try again.</p><p><br /></p>';
        } //End of if (empty($errors)) IF.

        mysqli_close($dbc);
        
    } //End of the main Submit conditional.

  ?>

<h1>Register</h1>

<form action="register.php" method="post" onsubmit="eg.regCheck();">

    <p>First Name:<input type="text" name="first_name" id="nameID" size="15" maxlength="20" 
                   value="<?php if(isset($_POST['first_name'])) 
                       echo $_POST['first_name']; ?>"/></p>
    <p>Last Name:<input type="text" name="last_name" size="15" maxlength="40" 
                  value="<?php if(isset($_POST['last_name']))
                      echo $_POST['last_name']; ?>"/></p>
    <p>Email Address:<input type="text" name="email" size="20" maxlength="60" 
                  value="<?php if(isset($_POST['email'])) 
                      echo $_POST['email']; ?>"/></p>
    <p>Password:<input type="password" name="pass1" size="10" maxlength="20" 
                       value="<?php if(isset($_POST['pass1'])) 
                           echo $_POST['pass1']; ?>"/></p>
    <p>Confirm Password:<input type="password" name="pass2" size="10" maxlength="20" 
                               value="<?php if(isset($_POST['pass2'])) 
                                   echo $_POST['pass2']; ?>"/></p>
    <p><input type="submit" name="submit" value="Register"/></p>

</form>

<script type="text/javascript">
    var eg = {};
	eg.$ = function(id){
		return document.getElementById(id);
	};
    eg.regCheck = function() {
        var uid = eg.$("nameID");
        if (uid.value == '') {
                alert('first_name can not empty!');

                return false;
        }
        return true;
    };
</script>

<?php include('include/footer.html')?>
 
