
<?php
function lang($phase){

    static $lang = array(
        // login page
        'LOGINFORM'     => 'استمارة الدخول',
        'USER'          => 'اسم المستخدم',
        'ENTERNAME'     => 'ادخل اسمك',
        'CONNAME'       => 'من فضللك : تاكد من صحة اسمك',
        'PASS'          => 'الرقم السري',
        'ENTERPASS'     => 'ادخل رقمك السري',
        'CONPASS'       => 'من فضللك تاكد من ان رقمك السري لا يقل عن ثمانيه احرف',
        'LOGIN'         => 'دخول',       
        //navbar page
        'HOME'          => 'الصفحة الرئيسية',
        'SECTIONS'      => 'الاقسام',
        'ITEMS'         => 'العناصر',
        'MEMBERS'       => 'الاعضاء',
        'STATISTICS'    => 'الاحصائيات',
        'COMMENTS'      => 'التعليقات',
        'LOGS'          => 'المدونة',
        'Admin'         => 'ادمن',
        'VISITSHOP'     => 'زيارة الموقع' ,
        'EDITPROFILE'   => 'تعديل اللف الشخصي',
        'SETTINGS'      => 'الاعدادات',
        'LOGOUT'        => 'خروج',
        'DASHBOARD'     => 'لوحة التحكم' ,
        'TOTALCOMMENTS' => 'جميع التعليقات' ,
        'TOTALITEMS'    => 'جميع العناصر',
        'TOTALMEMBERS'  => 'جميع الاعضاء',
        'PENDINGMEMBERS'=> 'الاعضاء الغير مفعلين',
        // Edit Members page
        'USERNAME'      => 'اسم المستخدم',
        'PASSWORD'      => 'الرقم السري',
        'EMAIL'         => 'الايميل',
        'FULLNAME'      => 'الاسم بالكامل',
        'SAVE'          => 'حفظ',
        'CEUP'          => 'اسف : انت غير مسموح لك ان تكون هنا', // CANT ENTER UPDATE PAGE
        'UPDATE'        => 'تعديل',
        'BACK'          =>'رجوع',
        'EDITMEMBERS'   => 'تعديل الاعضاء',
        'UPDATEMEMBERS' => 'تحديث بيانات الاعضاء',
        'CANTUPDATE'    => 'اسف عليك ان تدخل كل حقول الاستمارة او يجب ان لا تقل كلمة السر عن سبعة احرف',
        'SUCCESSUPDATE' => 'تم : تم تحديث البيانات بنجاح',
        'CHECK'         => 'افحص البيانات',
        'Re-Enter'      => "اعد ادخال البيانات",
        'ERROR'         => 'رجوع'
    );
    
    return $lang[$phase] ; 

}
?>