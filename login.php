<?php include "nav.php";?>




<?php 
$errorslogin = ['result' =>'' ]; 
$vsuccess=['result'=>''];
if(isset($_GET['vsuccess'])){
    $vsuccess['result']='you account has been verified successfully';
}
else if(isset($_GET['chsuccess'])){
    $vsuccess['result']='you account password has been changed successfully';
}



session_start();
if(isset($_POST['login'])){
    $email =clear($_POST['email']);
    $_SESSION['email']=$email;
    $password=clear($_POST['password']);
    
    if(empty($email)  && empty($password)){
        $errorslogin['result']='please fill the blanks';
    }
    else if(empty($email)){
        $errorslogin['result']='please enter the email';
    }
    else if(empty($password)){
        $errorslogin['result']='please enter the password';
    }
    else{
        $password = hash('gost',$password);
        $query =mysqli_query($db, "SELECT * FROM `users` WHERE `email`='$email' AND `password` ='$password'");
        if(mysqli_num_rows($query)==1){
            $statuscheck =mysqli_query($db,"SELECT * FROM `users` WHERE `email` ='$email' AND `status`=1 AND `password`='$password'");

            if(mysqli_num_rows($statuscheck)==1){
                echo "esh dakat";
            }
            else{
                $NewOTP = rand(9999, 1111);
                $subject='Verification code';
                $message="Your verification code is $NewOTP";
                $sender ="FROM: your email";
                if(mail($email,$subject,$message,$sender)){
                    $ChangeOTP=mysqli_query($db, "UPDATE `users` SET `OTP` ='$NewOTP' WHERE `email`='$email'  AND `password` ='$password'");
                    header("location:verification.php");
                }
                else{
                    echo "verification code failed to send";
                }
            }
        }
        else{
            $errorslogin['result']='wrong email or password';
        }
    }

   
       
}



?>





<style>
    form{
        background:white;
        width: 500px;
        margin: auto;
        margin-top:300px;
        border-radius:20px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        
    }
    
    input{
        background-color:#FFFFF9;
        font-size:25px;
        border-radius:20px;
        outline:none;

    }
    ::-webkit-input-placeholder{
        color:#000;
        font-size:20px;
    }
</style>


<form   action="login.php" method="POST">
    <div  class="text-center p-5 ">
            <div class='text-success'>
                <h2><?php echo $vsuccess['result'] ?></h2>
            </div>
            <div class='pb-5'>
                <h2>Login</h2>
            </div>
            
            <div class='text-danger'>
                <h2><?php echo $errorslogin['result'] ?></h2>
            </div>
            <div class='p-2 h-200px'>
                <input name='email' class='w-100 text-center ' style="height:50px;"  placeholder="Email" type="email">
            </div>
            <div class='p-2'>
                <input name='password' class='w-100 text-center'  style="height:50px;" placeholder="Password" type="password">
            </div>
            <div class='p-2'>
                <button name='login'  class="btn btn-primary" style="border-radius:25px; width:150px; height:50px; font-size:20px;">Login</button>
            </div>

            <div>
                <a href="forgetpassword.php" style="font-size:18px;">Forget password?</a>
            </div>
            <div>
                <a href="signup.php" style="font-size:18px; ">Sign up new account</a>
            </div>

    </div>
</form>
