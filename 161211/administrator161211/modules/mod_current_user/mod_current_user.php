<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

   $user =& JFactory::getUser();

   $showusername       = $params->def('showusername', 1);
   $showuserlabel      = $params->def('showusernamelbl', '');
   $showregdate        = $params->def('showregdate', 1);
   $showregdatelabel   = $params->def('showregdatelbl', '');
   $showlastlogin      = $params->def('showlastlogin', 1);
   $showlastloginlabel = $params->def('showlastloginlbl', '');
   $showname           = $params->def('showname', 1);
   $shownamelabel      = $params->def('shownamelbl', '');
   $showuseremail      = $params->def('showuseremail', 1);
   $showuseremaillabel = $params->def('showuseremaillbl', '');
   $showusertype       = $params->def('showusertype', 1);
   $showusertypelabel  = $params->def('showusertypelbl', '');
   $labelcolor         = $params->def('labelcolor', '000077');
   $textcolor          = $params->def('textcolor', '888888');

   $username = $user->username;
   $lastlogin = substr($user->lastvisitDate, 0, 16);
   # $lastlogin = date("Y-m-d H:i", $user->lastvisitDate);
   $regdate =  substr($user->registerDate, 0, 10);
   $name = $user->name;
   $email = $user->email;
   $usertype = $user->usertype;

   if ($user->id != 0) {
       // registered members
       if ($showname == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$shownamelabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">$name</span><br>";
       if ($showusername == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$showuserlabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">$username</span><br>";
       if ($showuseremail == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$showuseremaillabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">$email</span><br>";
       if ($showusertype == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$showusertypelabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">$usertype</span><br>";
       if ($showlastlogin == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$showlastloginlabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">$lastlogin</span><br>";
       if ($showregdate == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$showregdatelabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">$regdate</span><br>";
   } else {
       if ($user->guest) {
	       if ($showusername == 1) echo "<b><span style=\"color: #" . $labelcolor . ";\">$showuserlabel</span></b><br><span style=\"font-family: courier new; color: #" . $textcolor . ";\">Guest</span><br>";
       } else {
               echo "Please login.";
       }
   }


?>