<?php include "nav.php";?>





<?php
session_start();
$errorsverify = ['result' =>'' ]; 


if(isset($_POST['verify'])){
    
    $vcode=clear($_POST['vcode']);

    $_SESSION['otp']=$vcode;
    
    if(empty($vcode)){
        $errorsverify['result']='please enter the code';
    }
    else{
        
            $email=$_SESSION['email'];
            $check=mysqli_query($db, "SELECT * FROM `users` WHERE `OTP` ='$vcode' AND `email` ='$email'");
            if(mysqli_num_rows($check)==1){
                header("location:newpassword.php");
            }
            else{
                $errorsverify['result']='wrong code!';
            }
        
        
    }
    
    
    
    
}





if(isset($_POST['resend'])){
        $email=$_SESSION['email'];
        $NewOTP = rand(9999, 1111);
        $subject='Verification code';
        $message="Your verification code is $NewOTP";
        $sender ="FROM:your email";
        if(mail($email,$subject,$message,$sender)){
            $ChangeOTP=mysqli_query($db, "UPDATE `users` SET `OTP` ='$NewOTP' WHERE `email`='$email'");
            
        }
        else{
            $errorsverify['result']='failed to send verification code!';
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


<form   action="forgetpasswordverify.php" method="POST">
    <div  class="text-center p-5 ">
            <div class='pb-'>
                <h2>Recover your account</h2>
            </div>
            <div class='pb-3'>
                <p style='font-size:20px;'>an email has been sent to your account</p>
            </div>
            <div class='text-danger'>
                <h2><?php echo $errorsverify['result'] ?></h2>
            </div>
            <div class='p-2'>
                <input name='vcode' class='w-100 text-center'  style="height:50px;" placeholder="Verification code" type="text">
                
            </div>
            
                
            
            
            <div class='p-2'>
                <button name='verify'  class="btn btn-warning" style="border-radius:25px; width:150px; height:50px; font-size:20px;">Verify</button>
            </div>
            <div class='p-2'>
                <button id="seconds" name='resend'  class="btn btn-primary" style="border-radius:25px; width:150px; height:50px; font-size:20px;">Resend code</button>
            </div>
            <div>
                <a href="forgetpassword.php" style="font-size:18px;">change Email</a>
            </div>
            

    </div>
</form>






<script>
    timeLeft = 30;


    


    


    function countdown() {
    

	timeLeft--;
	document.getElementById("seconds").innerHTML = String( timeLeft );
	if (timeLeft > 0) {
		setTimeout(countdown, 1000);
        document.getElementById("seconds").disabled = true;
        document.getElementById("seconds").style.cursor = 'not-allowed';
	}
    else{
        document.getElementById('seconds').innerHTML='resend';
        document.getElementById("seconds").disabled = false;
        document.getElementById("seconds").style.cursor = 'pointer';
    }
};

setTimeout(countdown, 1000);
</script>