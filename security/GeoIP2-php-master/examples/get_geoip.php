<?php

require 'geoip.php';

$ans = get_geoip();
echo "<pre>";
print_r($ans);
