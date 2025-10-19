<?php


require 'vendor/autoload.php';
if(isset($_POST))
{
  echo "success";
}
else
{
    echo "error";
}


ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Hello, errors!" );
