<?php

//$uploaddir = './uploads/';   message/rfc822
$uploaddir = '../obj_file/st_acidente/';
$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file))
{
//  echo "success";
  echo $file;
}
else
{
	echo "error";
}
?>