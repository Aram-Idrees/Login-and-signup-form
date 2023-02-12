<?php include "nav.php";?>
<?php include "user-control.php"; ?>


<!-- signup -->
<?php 
session_start();
$errorssignup = ['result' =>'']; 
if(isset($_POST['signup'])){
    
    $name =clear($_POST['name']);
    $email =clear($_POST['email']);
    $password=clear($_POST['password']);
    $age=clear($_POST['age']);
    $gender=clear($_POST['gender']);

    if((empty($name) && empty($email)) && (empty($password) && empty($age))){
        $errorssignup['result']='please fill the blanks';
    }
    else if(empty($name)){
        $errorssignup['result']='please enter your name';
    }
    else if(empty($email)){
        $errorssignup['result']='please enter your email';
    }
    else if(empty($password)){
        $errorssignup['result']='please enter the password';
    }
    else if(empty($age)){
        $errorssignup['result']='please enter your age';
    }
    else{
        if(strlen($password)<8){
            $errorssignup['result']='your password must be greater than 8 characters!';
        }
        else{
            $status=clear(0);
            $OTP = rand(9999, 1111);
            $password = hash('gost',$password);
            $query=mysqli_query($db, "INSERT INTO `users` (`name` , `email` , `password` , `age`,`gender`,`OTP`,`status`) VALUES ('$name' , '$email' , '$password','$age' , '$gender','$OTP','$status')");
            if($query){
        
                $subject='Verification code';
                $message="Your verification code is $OTP";
                $sender ="FROM:Your email";
                if(mail($email,$subject,$message,$sender)){
                $_SESSION['email']=$email;
                header("location:verification.php");
            
                }
                else{
                    $errorssignup['result']='cannot send the verification code';
                }
            }
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
    select{
        background-color:#FFFFF9;
        font-size:20px;
        border-radius:20px;
        outline:none;

    }
    ::-webkit-input-placeholder{
        color:#000;
        font-size:20px;
    }
</style>


<form action="signup.php" method="POST">
    <div  class="text-center p-5 ">
            <div class='pb-5'>
                <h2>Sign up</h2>
            </div>
            <div class='text-danger'>
                <h2><?php echo $errorssignup['result'] ?></h2>
            </div>
            <div class='p-2 h-200px'>
                <input name='name' class='w-100 text-center ' style="height:50px;"  placeholder="Name" type="text">
            </div>
            <div class='p-2 h-200px'>
                <input name='email' class='w-100 text-center ' style="height:50px;"  placeholder="Email" type="email">
            </div>
            <div class='p-2'>
                <input name='password' class='w-100 text-center'  style="height:50px;" placeholder="Password" type="password">
            </div>
            <div class='p-2 h-200px'>
                <input name='age' class='w-100 text-center ' style="height:50px;"  placeholder="Age" type="number">
            </div>
            <div class='p-2 h-200px'>
                <select name='gender' class='w-100 text-center ' style="height:50px;" >
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class='p-2'>
                <button name='signup'  class="btn btn-primary" style="border-radius:25px; width:150px; height:50px; font-size:20px;">Sign up</button>
            </div>

            <div>
                <a href="login.php" style="font-size:18px;">Already have an account?</a>
            </div>
            

    </div>
</form>
