<?php
function lang($phrase){

  static $lang=array(
     // Dasboard page
     'Admin_home'=>'Home',
     'sectiions'=> 'Categories',
     'Admin_name'=>'Ahmed',
     'Ed_prof'=>'Edit profile',
     'sett'=>'Settings',
     'lgo'=>'Logout',
     'catg'=>'Catgs.php'
);
return $lang[$phrase];
}
?>