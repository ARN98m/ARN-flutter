<?php
$url = $_SERVER['HTTP_REFERER'];

header(("refresh:0;url=$url"));

exit();
