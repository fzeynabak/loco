<?php  
$password = 'Mos6678232';  
$hash = password_hash($password, PASSWORD_BCRYPT);  
echo $hash;  
?> 