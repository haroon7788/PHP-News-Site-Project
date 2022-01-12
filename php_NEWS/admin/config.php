<?php

$recordsLimitPerPage = 4;
$hostName = "http://localhost/php_news";

$connection = mysqli_connect('localhost', 'root', '', 'news_site')
   or die("Connection Failed: " . mysqli_connect_error());
   
?>