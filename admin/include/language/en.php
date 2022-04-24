<?php
//en.php
function lang($phase){

    static $lang = array(
        // login page
        'LOGINFORM'     => 'Login Form',
        'USER'          => 'User Name',
        'ENTERNAME'     => 'Enter Your Name',
        'CONNAME'       => 'Please Make Sure That Your Name Is Correct :D',
        'PASS'          => 'Password',
        'ENTERPASS'     => 'Enter Your Password',
        'CONPASS'       => 'Please Make Sure That Your Password Is More Than 8 Characters !',
        'LOGIN'         => 'Login',
        //navbar page
        'HOME'          => 'Home',
        'SECTIONS'      => 'Categores',
        'ITEMS'         => 'Items',
        'MEMBERS'       => 'Members',
        'COMMENTS'      => 'Comments',
        'STATISTICS'    => 'Statistics',
        'LOGS'          => 'Logs',
//        'AdmainName'    => $_SESSION["admin"],
        'AdmainName'    => 'Ali',
        'EDITPROFILE'   => 'Edit Profile',
        'SETTINGS'      => 'Settings',
        'LOGOUT'        => 'Logout',
        // Manage Member Page
        'MANAGE'        => 'Manage Members',
        // Add Member Page
        'ADD'           => 'This Is Add Page',
        'ADDMEMBER'     => 'Add New Member',
        'ADDONLY'       => 'Add',
        'SUCCESSADD'    => 'Add Process Completed',
        // Edit Members page
        'USERNAME'      => 'Username',
        'PASSWORD'      => 'Password',
        'EMAIL'         => 'Email',
        'FULLNAME'      => 'Fullname',
        'SAVE'          => 'Save',
        'CEUP'          => 'Sorry , You Are Not Allowed To Be Here :DD', // CANT ENTER UPDATE PAGE
        'UPDATE'        => 'Update',
        'BACK'          =>'Back',
        'EDITMEMBERS'   => 'Edit Members',
        'UPDATEMEMBERS' => 'Update Members',
        'CANTUPDATE'    => 'Sorry , You Should Enter All Fields In Form Or Password Should Be More Than 7 Characters',
        'SUCCESSUPDATE' => 'Success , Data Successfully Updated',
        'CHECK'         => 'Check Data',
        'Re-Enter'      => "Re-Enter Data",
        'ERROR'         => 'Back'
    );
    
    return $lang[$phase] ; 

}
?>


