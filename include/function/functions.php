<?php

// function.php

/*
    ==============================================
    == This function Get Categores From End From Database
    
    ==============================================
*/

function notActive($user){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM users  WHERE userName = ? AND regStatus = 0 ") ;
    $stmt ->execute(array($user)) ;
    $ans = $stmt->rowCount() ; 
    return $ans ; 
}

/*
    ==============================================
    == This function Get Categores From End From Database
    
    ==============================================
*/

function getParentCat($id){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM categores WHERE parent = 0 AND id = ? ORDER BY id ASC") ;
    $stmt ->execute(array($id)) ;
    $cats = $stmt->fetchAll() ; 
    return $cats ; 
}
function getCats(){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM categores WHERE parent = 0 ORDER BY id ASC") ;
    $stmt ->execute() ;
    $cats = $stmt->fetchAll() ; 
    return $cats ; 
}
function getSubCats(){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM categores WHERE parent != 0 ORDER BY id ASC") ;
    $stmt ->execute() ;
    $subcats = $stmt->fetchAll() ; 
    return $subcats ; 
}

function getSubCatsOf($mainCatId){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM categores WHERE parent = ? ORDER BY id ASC") ;
    $stmt ->execute(array($mainCatId)) ;
    $subcats = $stmt->fetchAll() ; 
    return $subcats ; 
}
/*
    ==============================================
    == This function Get Items From End From Database
    == it will take 3 parameters Aim To User ID

    ==============================================
*/

function getItems($catId, $start_from, $item_count){
    global $con ; 

    $stmt = $con->prepare("SELECT parent FROM categores WHERE id = ?") ;
    $stmt ->execute(array($catId)) ;
    $items = $stmt->fetchAll() ; 
    if($items[0]["parent"] == "0"){
        //main category
        $stmt = $con->prepare("SELECT * FROM items WHERE cat_id in (select  id FROM categores WHERE categores.parent = $catId ) AND apporove = 1 ORDER BY item_id ASC LIMIT $start_from, $item_count") ;
        $stmt ->execute(array($catId)) ;
        $items = $stmt->fetchAll() ; 
        return $items ; 
    }else{
        //subCategory
        $stmt = $con->prepare("SELECT * FROM items WHERE cat_id = ? AND apporove = 1 ORDER BY item_id ASC LIMIT $start_from, $item_count") ;
        $stmt ->execute(array($catId)) ;
        $items = $stmt->fetchAll() ; 
        return $items ; 
    }
}

function getItemsConut($catId){
    global $con ; 

    $stmt = $con->prepare("SELECT parent FROM categores WHERE id = ?") ;
    $stmt ->execute(array($catId)) ;
    $items = $stmt->fetchAll() ; 
    if($items[0]["parent"] == "0"){
        //main category
        $stmt = $con->prepare("SELECT * FROM items WHERE cat_id in (select  id FROM categores WHERE categores.parent = $catId ) AND apporove = 1 ORDER BY item_id ASC") ;
        $stmt ->execute(array($catId)) ;
        $items = $stmt->rowCount() ; 
        return $items ; 
    }else{
        //subCategory
        $stmt = $con->prepare("SELECT * FROM items WHERE cat_id = ? AND apporove = 1 ORDER BY item_id ASC") ;
        $stmt ->execute(array($catId)) ;
        $items = $stmt->rowCount() ; 
        return $items ; 
    }
}
/*
    ==============================================
    == This function Get Items From End From Database
    == it will take 3 parameters Aim To User ID

    ==============================================
*/

function getTags($tagName, $start_from, $item_count){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM items WHERE item_tags like '%" . $tagName . "%' AND apporove = 1 ORDER BY item_id DESC LIMIT $start_from, $item_count") ;
    $stmt ->execute() ;
    $items = $stmt->fetchAll() ; 
    return $items ; 
}
function getTagsCount($tagName){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM items WHERE item_tags like '%" . $tagName . "%' AND apporove = 1 ORDER BY item_id DESC") ;
    $stmt ->execute() ;
    $items = $stmt->rowCount() ; 
    return $items ; 
}

/*
    ==============================================
    == This function Get Items From End From Database
    == it will take 3 parameters Aim To User ID

    ==============================================
*/

function getAllItems(){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM items WHERE apporove = 1 ORDER BY add_date DESC") ;
    $stmt ->execute() ;
    $items = $stmt->fetchAll() ; 
    return $items ; 
}


























/*

-Get Title Function To Get The Title Of The Current Page

*/

function getTitle(){
    global $pageTitle ; 
    $pageTitle = isset($pageTitle)  ?  $pageTitle : "Default Title" ;
    return $pageTitle ; 
}


// redirect function 

function redirect($errMes, $errTime = 2, $page="Home", $url=null){
    
    
    if($url === null){
        $url ="index.php" ; 
    }
//    else{
//        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
//            $url = $_SERVER['HTTP_REFERER'] ; 
//        }else{
//            $url ="index.php" ;
//        }
//    }
//    
    echo $errMes ; 
    echo "<div class='container text-center' style='color:#675858'><h2 class='h1'>You Will Directly To $page Page After ".$errTime." Seconds</h2></div>" ; 
    header("refresh:$errTime;url=$url") ;
    exit() ; 
}



// query function

/*
    ==============================================
    == This function created to manage all query which related to ADD || EDIT & UPDATE || DELETE operation
    == it will take 6 parameters
    ==============================================
*/

function doQuery($queryType='x', $name='x', $email='x', $fullname='x', $pass='x', $userid=0){
    
    global $con ;
    global $row ;
    global $newName ;
    global $newEmail ;
    global $newFullname ;
    global $pass ;
    
    if($queryType=='insert'){   // when Add Members
        
        $stmt = $con->prepare("SELECT * FROM users WHERE userName = ?") ;
        $stmt->execute(array($name)) ;
        $count = $stmt->rowCount() ; 
        if($count >= 1){
            return false ; 
        }else{
            $stmt = $con->prepare("INSERT INTO users(userName, email, fullname, password, regStatus, date) VALUES(?, ?, ?, ?, 1, now())") ;
            $stmt->execute(array($name, $email, $fullname, $pass)) ; 
            return true ; 
        }
        
    }elseif($queryType=='insertbeforeedit'){   // when Add Members
        
        $stmt = $con->prepare("SELECT * FROM users WHERE userName = ?") ;
        $stmt->execute(array($name)) ;
        if($stmt -> rowCount() == 1){
            return true ; 
        }else{
            return false ;  
        }
        
    }elseif($queryType == 'edit'){  // when Edit Members
        
        if($userid != 0){
            $stmt = $con->prepare("SELECT * FROM users WHERE userId = ? LIMIT 1");
            $stmt -> execute(array($userid));
            $row = $stmt->fetch() ;
            if($stmt -> rowCount()){
                return true ;
            }
            return false ; 
        }
        
    }elseif($queryType == 'update'){  // when Update Members
        
        $stmt = $con->prepare("SELECT userName FROM users WHERE userId=$userid") ;
        $stmt->execute() ;
        $row = $stmt->fetch() ;
        $oldName = $row["userName"] ; 
        $newName = $name  ; 
        if($oldName === $newName){
                $stmt = $con->prepare("UPDATE users SET userName= ?, password=?, email=?, fullname=? WHERE userId=?");
                $stmt->execute(array($newName, $pass, $email, $fullname, $userid)) ;
                if($stmt->execute(array($name, $pass, $email, $fullname, $userid))){
                    return true ; 
                }else{
                    return false ; 
                } 
        }else{

            $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE userName = ?") ;
            $stmt -> execute(array($newName)) ;
            $count = $stmt->fetchColumn() ; 
            if($count == 0 ){
                $stmt = $con->prepare("UPDATE users SET userName= ?, password=?, email=?, fullname=? WHERE userId=?");
                $stmt->execute(array($newName, $pass, $email, $fullname, $userid)) ;
                return true ; 
            }else{
                return false ; 
            }
        }
    
    }elseif($queryType == 'aporove'){  // when Update Members
        
            $stmt = $con->prepare("UPDATE users SET regStatus = 1 WHERE userId=?");
            $stmt->execute(array($userid)) ;
            if($stmt->execute(array($userid))){
                return true ;
            }else{
                return false ;
            } 
        
    }elseif($queryType == 'delete'){  // when Delete Members
        
        if($userid != 0){
            $stmt = $con->prepare("DELETE FROM users WHERE userId = ?");
            $stmt -> execute(array($userid));
            if($stmt -> rowCount()){
                return true ;
            }
            return false ; 
        }   
    }
    
}

/*
    ==============================================
    == This function Get Count Of All Pending Members At Selected Table
    == it will take 1 parameters Aim To Table Name
    == $item Aim To The Column Name in Table At Databaes
    == $table Aim To Table Name In Database
    ==============================================
*/

function getPendingCount($tableName){
    global $con ; 
    $stmt = $con->prepare("SELECT COUNT(*) FROM $tableName WHERE regStatus=0 AND groupId!=1") ;
    $stmt ->execute() ;
    return $stmt->fetchColumn() ; 
}

/*
    ==============================================
    == This function created to Get All Column In Selected Table
    == it will take 2 parameters Aim To Table Name
    == $item Aim To The Column Name in Table At Databaes
    == $table Aim To Table Name In Database
    ==============================================
*/

function getCount($item, $tableName){
    global $con ; 
    $stmt = $con->prepare("SELECT COUNT($item) FROM $tableName") ;
    $stmt -> execute() ;
    return $stmt->fetchColumn() ; 
}

/*
    ==============================================
    == This function Check User Apporoval
    == it will take 1 parameters Aim To User ID

    ==============================================
*/

function checkApporov($userId){
    global $con ; 
    $stmt = $con->prepare("SELECT * FROM users WHERE userId = $userId AND regStatus = 0") ;
    $stmt ->execute() ;
    return $stmt->fetchColumn() ; 
}
/*
    ==============================================
    == This function Check if item exist in table at datbase
    == it will take 3 parameters Aim To User ID

    ==============================================
*/

function checkItem($select, $table, $value){
    global $con; 
    $stmt = $con->prepare("SELECT $select FROM $table WHERE $select = ?") ;
    $stmt -> execute(array($value)) ;
    $count = $stmt->rowCount() ; 
    return $count ; 
}

/*
    ==============================================
    == This function Get Data From End 
    == it will take 1 parameters Aim To User ID

    ==============================================
*/

function getLatest($select, $table, $order, $limit = 5){
    global $con ; 
    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit") ;
    $stmt ->execute() ;
    $rows = $stmt->fetchAll() ; 
    return $rows ; 
}


?>


















