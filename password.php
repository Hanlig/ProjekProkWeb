<?php
$password_polos = '123';
$hash_password = password_hash($password_polos, PASSWORD_DEFAULT);

echo "Password Anda: " . $password_polos;
echo "<br><br>";
echo "Kode Hash untuk Database:<br>";
echo '<textarea rows="3" cols="70" readonly>' . $hash_password . '</textarea>';
?>