<?php

require __DIR__ . '/../vendor/autoload.php';

use GeoIp2\Database\Reader;

srand(0);

$reader = new Reader('GeoLite2-City.mmdb');

/*
$count = 500000;
$startTime = microtime(true);
for ($i = 0; $i < $count; ++$i) {
    // $ip = long2ip(rand(0, pow(2, 32) - 1));
    //print_r(pow(2, 32) - 1);
    $v = (int) pow(2, 32) - 1;
    $ip = long2ip(rand(0, $v));
    // print_r($ip); exit();

    try {
        $t = $reader->city($ip);
    } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
    }
    if ($i % 10000 === 0) {
        // echo $i . ' ' . $ip . "\n";
    }
}
$endTime = microtime(true);

$duration = $endTime - $startTime;
echo 'Requests per second: ' . $count / $duration . "\n";
*/

// '60.243.87.72'

// print_r($_SERVER['HTTP_X_FORWARDED_FOR']); exit();

// $record = $reader->city('60.243.87.72');
$record = $reader->city($_SERVER['HTTP_X_FORWARDED_FOR']); 

print($record->country->isoCode . " - isoCode <br> "); // 'US'
print($record->country->name . " - name <br> "); // 'United States'
print($record->country->names['zh-CN'] . " - name <br> "); // '美国'

print($record->mostSpecificSubdivision->name . " - mostSpecificSubdivision name  <br> "); // 'Minnesota'
print($record->mostSpecificSubdivision->isoCode . " - mostSpecificSubdivision isocode <br> "); // 'MN'

print($record->city->name . " - city name <br> "); // 'Minneapolis'

print($record->postal->code . " - postal code <br> "); // '55455'

print($record->location->latitude . " - latitude <br> "); // 44.9733
print($record->location->longitude . " - longitude <br> "); // -93.2323

print($record->traits->network . " - network <br> "); // '128.101.101.101/32'

