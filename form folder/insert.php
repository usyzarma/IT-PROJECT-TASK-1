<?php
$password = $_POST ['password'];
$gender = $_POST ['gender'];
$email = $_POST ['email'];
$phonecode = $_POST ['phonecode'];
$phone = $_POST ['phone'];

if (!empty($username) || !empty($password)  ||  !empty($gender) ||   !empty($email)  ||  
   !empty($phonecode) ||    !empty($phone)){
      $host = "localhost";
      $dbUsername = "root";
      $dbPassword = " ";
      $dbname = "mysql";

             //create connections
      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect error('. mysqli_connect_errmo().') '.mysqli_connect_error());
    } else {
        $SELECT = "SELECT email From register Where email = ?  Limit 1";
        $INSERT = "INSERT Into register  (username, password, gender, email
            phonecode, phone)  values (?,?,?,?,?,?)";

              //prepare statement
              $stmt = $conn->prepare($SELECT);
              $stmt ->bind_param("s", $email);
              $stmt ->execute();
              $stmt ->bind_result($email);
              $stmt ->store_result();
              $rnum = $stmt ->num_rows;
              
              if ($rnum==0){
                  $stmt ->close();

                  $stmt = $conn ->prepare($INSERT);
                  $stmt ->bind_param("ssssii", $username, $password, $gender, $email, $phonecode,$phone);
                  $stmt ->execute();
                  echo "New record inserted Successfully";

            } else {
                echo "Someone already registered using this email";
            }
            $stmt ->close();
            $conn ->close();
    }
   } else {
       echo "All field are required";
       die();
   }

?>