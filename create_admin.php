<?php

define('PREFIX_SALT', 'FT(8x5<rc6R}');
define('SUFFIX_SALT', '8d*d5XU&.C2v');

$pass = '';

$hashSecure = md5(PREFIX_SALT.$pass.SUFFIX_SALT);

echo $hashSecure;
?>
