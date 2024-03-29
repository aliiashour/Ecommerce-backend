
<?php
// index.php
session_start() ;
$nonav = '' ;
$pageTitle = "Login" ;
//$ar='' ;
if(isset($_SESSION["user"])){
    header("location:index.php") ;
}

include "init.php" ;

// Log in Page

if($_SERVER["REQUEST_METHOD"] == "POST" && strlen($_POST["user"]) > 0 && strlen($_POST["password"]) >= 8 && $_GET["do"]=='login' )
{
    $name = $_POST["user"];
    $pass = $_POST["password"];
    $hashedpass = sha1($pass) ;
    $stmt = $con->prepare("SELECT 
                                userId, userName, groupId, password 
                           FROM 
                                users 
                           WHERE 
                                userName = ? 
                           AND 
                                password = ?
                                ") ;
    $stmt->execute(array($name, $hashedpass)) ;
    $data = $stmt->fetch()  ;
    $res = $stmt->rowCount()  ;
    
    if($res)
    {
		/////////////////////////////
		if($data["groupId"]){
			//this is a admin one
			$_SESSION["admin"] 	= $data["userName"] ;
			$_SESSION["adminId"] = $data['userId'] ;
		}
		$_SESSION["user"] 	= $data["userName"] ;
		$_SESSION["uid"] = $data["userId"] ;
		header("location:index.php") ; 
    	exit() ; 
    }
}

// Sign Up Page

if($_SERVER["REQUEST_METHOD"] == "POST" && strlen($_POST["user"]) > 0 && $_GET["do"]=='signup' )
{
    $name 		= $_POST["user"];
    $pass 		= $_POST["password"];
    $hashedpass = sha1($pass) ;
    $email 		= $_POST["email"] ; 
    $fullname 	= $_POST["fullname"] ; 
    

    $errors = array(); 

    // Start Check Inpyts

	    if( $name != '' ){

	    	
	    	$name = filter_var($name, FILTER_SANITIZE_STRING)  ; 
	 
	    	
	    	if(strlen($name) < 2){

				$errors[] = '<div class="alert alert-danger text-center">Yor Name Should be At lest 2 Characters</div>' ;

	    	}
			
			// check Name In Database
	    	
	    	$isExist = checkItem('userName', 'users', $name) ;  

	    	if($isExist){

	    		$errors[] = '<div class="alert alert-danger text-center">This user name is not allowed<br>Please, Enter Another One</div>' ;
	    	}

	    }else{
	    	$errors[] = '<div class="alert alert-danger text-center">Enter Your Name</div>' ;
	    }

		if(strlen($pass) < 8){

			$errors[] = '<div class="alert alert-danger text-center">Password Should be More Than 7 Character</div>' ;	
		
		}
		if(strlen($fullname) < 8 || $fullname == ''){

			$errors[] = '<div class="alert alert-danger text-center">Full name Should be More Than 7 Character</div>' ;	
		
		}
		if( $email !='' ){

			$email = filter_var($email, FILTER_SANITIZE_EMAIL) ; 

			if( filter_var($email, FILTER_VALIDATE_EMAIL) != true){

				$errors[] = '<div class="alert alert-danger text-center">This Email Is Not Valide<br>please, Enter Valid Email</div>' ;			
			}

		}else{
	    	$errors[] = '<div class="alert alert-danger text-center">Enter Your Email</div>' ;
	    }
    
    // End Check Inpyts
	
	if(empty($errors)){

		$stmt = $con->prepare("INSERT INTO users(userName, password, email, date, fullName) VALUES (?, ?, ?, now(), ?) ");
		$stmt -> execute(array($name, $hashedpass, $email, $fullname)) ;   
		'<div class="alert alert-success text-center">Welcome In Our Website ' . $name . '</div>' ; 
		$success = '' ; 
	}
}

?>


<div class="container">
	
	<h2 class="h1 text-center chose" style="margin-top: 50px;cursor: pointer;">
    	<span class="login active" data-class='login'>Login</span>
    	<b> | </b>
    	<span class="signin" data-class='signup'>Signin</span>
    </h2>

	<form class="form login"action="<?php echo $_SERVER["PHP_SELF"] ?>?do=login" method="POST">

	    <div class="form-group">
	        <input class="form-control" type="text" name="user" placeholder="Enter Your User Name" autocomplete="off" required>
	        <span class="aterisk">*</span>
	        <small>Please Make Sure That Your Name Is Correct :D</small>
	    </div>
	    
	    <div class="form-group">
	        <input class="form-control" type="password" name="password" placeholder="Enter Your Password" autocomplete="off" required >
	        <span class="aterisk">*</span>

	        <small>Please Make Sure That Your Password Is More Than 8 Characters !</small>
	    </div>
	    
	    <button class="btn btn-primary btn-block">Login</button>
	    <p class="lead text-center" id="response">
			<?php 
				if(!empty($errors)){
		
					echo '<div class="container" style="margin-top:100px">' ; 

					foreach ($errors as $error) {
					
						echo $error  ;

					}
					echo '</div>' ; 
				}
				if(isset($success)){
					echo 'User Successfully Signup'  ; 
				}
		    ?>
	    </p>

	</form>	

	<form class="form signup" action="<?php echo $_SERVER["PHP_SELF"] ?>?do=signup" method="POST">

	    <div class="form-group">
	        <input class="form-control" type="text" name="user" placeholder="Enter Your User Name" autocomplete="off" required>
	        <span class="aterisk">*</span>
	        <small>Please Make Sure That Your Name Is Correct :D</small>
	    </div>
	    <div class="form-group">
	        <input class="form-control" type="text" name="fullname" placeholder="Enter Your User Fullname" autocomplete="off" required>
	        <span class="aterisk">*</span>
	        <small>Please Make Sure That Your Fullname Is Correct :D</small>
	    </div>	    
	    <div class="form-group">
	        <input class="form-control pass" type="password" name="password" placeholder="Enter Your Password" autocomplete="off">
	        <i class="show-pass fa fa-eye"></i>
	        <small>Please Make Sure That Your Password Is More Than 8 Characters !</small>
	    </div>
    	<div class="form-group">
	        <input class="form-control" type="email" name="email" placeholder="Enter Your Email" autocomplete="on">
	        <small>EX::/ example123@example.com</small>
	    </div>
	    
        <input type="checkbox" name="checkbox" id="check" style="vertical-align: middle">
        <label for="check">remmber Me!</label>
    
	    
	    
	    <button class="btn btn-success btn-block">Signin</button>
	</form>

</div>

<?php  

include $tmpls . "footer.php" ; 
?>