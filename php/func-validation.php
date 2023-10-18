<?php  

function is_empty($var, $text, $location, $ms, $data){
   if (empty($var)) {
   	 # Error message
   	 $em = $text ." chưa nhập.";
   	 header("Location: $location?$ms=$em&$data");
   	 exit;
   }
   return 0;
}