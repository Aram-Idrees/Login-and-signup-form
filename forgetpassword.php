<?php include 'nav.php';?>



<?php
session_start();
$errorsforget = ['result' =>'']; 
if(isset($_POST['recover'])){
    $email=clear($_POST['email']);

    if(empty($email)){
        $errorsforget['result']='please enter the email';
    }
    else{
        $query =mysqli_query($db, "SELECT * FROM `users` WHERE `email` ='$email'");
        if(mysqli_num_rows($query)==1){
            $_SESSION['email']=$email;
            $email=$_SESSION['email'];
            $NewOTP = rand(9999, 1111);
            $subject='Verification code';
            $message="Your verification code is $NewOTP";
            $sender ="FROM:your email";
            if(mail($email,$subject,$message,$sender)){
                $ChangeOTP=mysqli_query($db, "UPDATE `users` SET `OTP` ='$NewOTP' WHERE `email`='$email'");
                header("location:forgetpasswordverify.php");
            }
            else{
                $errorsforget['result']='failed to send verification code!';
            }
        }
        else{
            $errorsforget['result']='we could not find any account with that email';
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


<form   action="forgetpassword.php" method="POST">
    <div  class="text-center p-5 ">
            <div class='pb-'>
                <h2>Password recovery</h2>
            </div>
            
            <div class='text-danger'>
                <h2><?php echo $errorsforget['result'] ?></h2>
            </div>
            <div class='p-2'>
                <input name='email' class='w-100 text-center'  style="height:50px;" placeholder="Your email" type="text">
                
            </div>
            
            <div class='p-2'>
                <button name='recover'  class="btn btn-warning" style="border-radius:25px; width:150px; height:50px; font-size:20px;">Recover</button>
            </div>
            
            <div>
                <a href="login.php" style="font-size:18px;">back to login</a>
            </div>
            

    </div>
</form>