<?php 

ob_start();

session_start();

$pageTitle='Add Ads' ; 

if(isset($_SESSION["user"])){

	// get Form Dataa Throw Request Method POST

	include 'init.php' ; 
	
	// get The Current User Id From Session To Add Items To It Ads

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        

        $imageName = $_FILES["image"]["name"] ;
        $imageTmp  = $_FILES["image"]["tmp_name"] ;
        $imageType = $_FILES["image"]["type"] ; 
        $imageSize = $_FILES["image"]["size"] ;

        // Exetinstion Allowed To Upload

        $allowedExetintion = array("jpeg", "jpg", "png", "gif") ;

        $imageExtention = explode('.', $imageName) ;
        
        $imageExtention = strtolower($imageExtention[1]) ; 
		
		$errors = array() ; 

		$name 		= filter_var($_POST["name"], FILTER_SANITIZE_STRING) ; 
		$desc 		= filter_var($_POST["description"], FILTER_SANITIZE_STRING) ; 
		$price 		= filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT) ; 
		$country 	= filter_var($_POST["country"], FILTER_SANITIZE_STRING) ; 
		$stat 		= filter_var($_POST["status"], FILTER_SANITIZE_NUMBER_INT) ; 
		$cat 		= filter_var($_POST["category"], FILTER_SANITIZE_NUMBER_INT) ;
		$tags 		= filter_var($_POST["tags"], FILTER_SANITIZE_STRING) ;

		if($name == '' || strlen($name) < 3){
			$errors[] = '<div class="alert alert-danger">Enter Item Name and It Should Be More Than 3 Characters</div>' ; 
		}
		if($desc == ''){
			$errors[] = '<div class="alert alert-danger">Enter Item Description</div>' ; 
		}
		if($price == ''){
			$errors[] = '<div class="alert alert-danger">Enter Item Price</div>' ; 
		}
		if($country == ''){
			$errors[] = '<div class="alert alert-danger">Enter Item Country</div>' ; 
		}
		if($stat == 0){
			$errors[] = '<div class="alert alert-danger">Enter Item Status</div>' ; 
		}
		if($cat == 0){
			$errors[] = '<div class="alert alert-danger">Enter Item Categores</div>' ; 
		}if($imageName == ''){
            $errors[] ="<div class='alert alert-danger'> Upload Your Image</div>" ;  
        
        }if(!in_array($imageExtention, $allowedExetintion) && !empty($imageName)){
            $errors[] ="<div class='alert alert-danger'>This Extention is Not <strong>Allowed</strong></div>" ;   
        }if($imageSize > 4194304){
            $errors[] ="<div class='alert alert-danger'>Image Size Can Not be More Than 4mb</div>" ; 
        }

        if(empty($errors)){
          
            $image = rand(0, 1000000) . '_' . $imageName ; 
            move_uploaded_file($imageTmp, "admin\upload\images\\" . $image ); 


            $stmt = $con->prepare("INSERT INTO 
                                            items(item_name, item_desc, price, country, status, add_date, cat_id, member_id, item_tags, image) 
                                   VALUES(:zx, :zxx, :zxxx, :zxxxx, :zxxxxx, now(), :zxxxxxx, :zxxxxxxx, :zxxxxxxxx, :zxxxxxxxx)") ; 
            
            $stmt->execute(array(
                'zx'        => $name,
                'zxx'       => $desc,
                'zxxx'      => $price,
                'zxxxx'     => $country,
                'zxxxxx'    => $stat,
                'zxxxxxx'   => $cat,
                'zxxxxxxx'  => $_SESSION['uid'],
                'zxxxxxxxx'	=> $tags,
                'zxxxxxxxx' => $image
            ));

            header("location:newad.php") ;  
	}
}

	

?>
<div class="block">
	<h2 class="h1 text-center">Add New Ads</h2>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				Add New Ads
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="editform ads" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

							<div class="form-group row">
							    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Name</strong></label>
							    <div class="col-sm-10">
							      <input type="text" 
							             class="form-control col-sm-10 float-right live-name" 
							             data-scope='card-title'
							             id="inputUsername" 
							             name="name" 
							             autocomplete="off" 
							             required 
							             placeholder="Enter Item Name" />
							    </div>
							</div>                    
							<div class="form-group row">
							    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Desc</strong></label>
							    <div class="col-sm-10">
							      <input type="text" 
							             class="form-control col-sm-10 float-right live-desc" 
							             data-scope='card-text'
							             id="inputUsername" 
							             name="description" 
							             autocomplete="off"
							             required
							             placeholder="Enter Item Description" />
							    </div>
							</div>                    
							<div class="form-group row">
							    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Price</strong></label>
							    <div class="col-sm-10">
							      <input type="text" 
							             class="form-control col-sm-10 float-right live-price" 
							             data-scope='card-price'
							             id="inputUsername" 
							             name="price" 
							             autocomplete="off"
							             required
							             placeholder="Enter Item Price" />
							    </div>
							</div> 
		                    <div class="form-group row">
		                        <label for="inputFullname" class="col-sm-2 col-form-label"><strong>Avatar</strong></label>
		                        <div class="col-sm-10">
		                          <input required type="file" class="form-control col-sm-10 float-right" id="inputFullname" name="image" placeholder="">
		                        </div>
		                    </div>   
							<div class="form-group row">
							    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Country</strong></label>
							    <div class="col-sm-10">
							      <input type="text" 
							             class="form-control col-sm-10 float-right" 
							             id="inputUsername" 
							             name="country" 
							             autocomplete="on"
							             required
							             placeholder="Enter Item Country Made" />
							    </div>
							</div>                    
							<div class="form-group row">
							    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Status</strong></label>
							    <div class="col-sm-10">
							        <select name="status" class="form-control offset-sm-2 col-sm-10">
							            <option value="0">...</option>
							            <option value="1">New</option>
							            <option value="2">Like New</option>
							            <option value="3">Used</option>
							            <option value="4">Old</option>
							            <option value="5">Very Old</option>
							        </select>
							    </div>
							</div>
		                    <div class="form-group row">
		                        <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Item Tags</strong></label>
		                        <div class="col-sm-10">
		                          <input type="text" 
		                                 class="form-control col-sm-10 float-right" 
		                                 id="inputUsername" 
		                                 name="tags" 
		                                 autocomplete="off"
		                                 placeholder="Enter Item Tags EX:// tag," />
		                        </div>
		                    </div>   
							<div class="form-group row">
							    <label for="inputUsername" class="col-sm-2 col-form-label"><strong>Category</strong></label>
							    <div class="col-sm-10">
							        <select name="category" class="form-control offset-sm-2 col-sm-10">
							            <option value="0">...</option>
							        <?php
							            
							           $stmt = $con->prepare("SELECT * FROM categores") ;
							           $stmt -> execute() ; 
							           $rows = $stmt -> fetchAll() ;
							           foreach($rows as $row ){
							               echo '<option value="'.$row["id"].'">'.$row["name"].'</option>' ; 
							           }
							               
							           
							        ?> 
							        </select>
							    </div>
							</div>
							<div class="form-group row">
							    <div class="col-sm-12">
							      <input type="submit" class="btn btn-success float-right btn-md" value="Add Item"> 
							    </div>
							</div>
						</form>
					</div>
					
					<div class="col-sm-6 col-md-4">
							
						<div class="card item-box live-preview">

							<img class="img-responsive card-img-top" src="layout/images/coffie.jpg" alt="item">
							
							<div class="caption">

								<h5 class="card-title">Title</h5> 

								<p class="card-text lead">Text</p>

								<span class="price card-price">Price</span> 

							</div> 
						
						</div>  
					
					</div>
				</div>
			</div>
		</div>
		<div class="errors" style="margin-top: 50px">
			<?php 

				if(!empty($errors)){

					foreach ($errors as $error) {
						echo $error ; 
					}

				}

			?>
		</div>
	</div>
</div>


<?php

	include $tmpls . 'footer.php' ; 
}else{

	header("location:log.php");
}


ob_end_flush() ; 

?>