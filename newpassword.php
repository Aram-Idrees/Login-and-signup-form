<?php include "nav.php";?>

<?php
session_start();
$errorsnewpass = ['result' =>'' ]; 

if(isset($_POST['confirm'])){
    $email=$_SESSION['email'];
    $OTP=$_SESSION['otp'];
    $newpassword=clear($_POST['newpassword']);
    $confirmpassword=clear($_POST['confirmpassword']);
    if(empty($newpassword) && empty($confirmpassword)){
        $errorsnewpass['result']='please fill the blanks';
    }
    else if(empty($newpassword)){
        $errorsnewpass['result']='please enter the first password';
    }
    else if(empty($confirmpassword)){
        $errorsnewpass['result']='please enter the second password';
    }
    else{
        if($newpassword == $confirmpassword){
            $query=mysqli_query($db, "SELECT * FROM `users` WHERE `email`='$email' AND `OTP`='$OTP' ");
            if(mysqli_num_rows($query)==1){
                $newpassword = hash('gost',$newpassword);
                $changepassword=mysqli_query($db, "UPDATE `users` SET `password`='$newpassword' WHERE `email`='$email' AND `OTP` ='$OTP'");
                session_unset();
                session_destroy();
                unset($email);
                unset($OTP);
                header("location:login.php?chsuccess");
            }
            else{
                echo "error dadat";
            }
        }
        else{
            $errorsnewpass['result']='the passwords does not match';
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


<form   action="newpassword.php" method="POST">
    <div  class="text-center p-5 ">
            
            <div class='pb-5'>
                <h2>New password</h2>
            </div>
            
            <div class='text-danger'>
                <h2><?php echo $errorsnewpass['result'] ?></h2>
            </div>
            <div class='p-2'>
                <input name='newpassword' class='w-100 text-center'  style="height:50px;" placeholder="New Password" type="password">
            </div>
            <div class='p-2'>
                <input name='confirmpassword' class='w-100 text-center'  style="height:50px;" placeholder="Confirm Password" type="password">
            </div>
            <div class='p-2'>
                <button name='confirm'  class="btn btn-primary" style="border-radius:25px; width:150px; height:50px; font-size:20px;">Confirm</button>
            </div>

            
            

    </div>
</form>