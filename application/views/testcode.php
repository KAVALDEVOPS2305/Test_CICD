<?php
echo "Hello"."<br/><br/><br/>";

echo password_hash('Test', PASSWORD_BCRYPT)."<br/><br/>";
echo password_hash('Test', PASSWORD_BCRYPT)."<br/><br/>";
// $hash = '$2y$10$I/tdXbXQuspNehrdXF/qTOM8CwBqMzmK8aA60gyX3Haoiq3xYyjKu';
$hash = '$2y$10$JuJTJxwH4W/46VQ/UDeRWuPPerdq4eFP2R6E9J8Q1mARPyoMF6f.a';
// $hash = '$2y$10$ofYoogMs6vT9r7h526Gzz.1Ckhm8uLu3GtD0zGzstk7u/spwPlsgS';
// $hash = '$2y$10$TwX8wsYkdiyMFvKxZ/8FPOC8yKRaoL1Y8EYgWXujKKOYoJ9bgOsBq';
// $hash = '$2y$10$jUbDFbqSPRIbWSLw3ghQJuSBRJejLK0FYTL4T0c/gzp8hwW4VrUM2';

// if($this->verifyHash($this->$hash,"Test") == TRUE)
if (password_verify('Test', $hash))
{
   echo 'Password is valid!'."<br/><br/><br/>";
}
else
{
   echo 'Invalid password.'."<br/><br/><br/>";
}


echo password_hash('rasmuslerdorf', PASSWORD_BCRYPT)."<br/>";

$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

if (password_verify('rasmuslerdorf', password_hash('rasmuslerdorf', PASSWORD_BCRYPT))) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}


?>