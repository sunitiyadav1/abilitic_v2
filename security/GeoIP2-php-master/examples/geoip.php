<?php

require __DIR__ . '/../vendor/autoload.php';

use GeoIp2\Database\Reader;

srand(0);

function get_geoip()
{
    // $path   = "D:\\xampp\htdocs\abilitic\security\GeoLite2-City_20200811\GeoLite2-City.mmdb";
    $path   = "/var/www/html/Abilitic/security/GeoLite2-City_20200811/GeoLite2-City.mmdb";

    $reader = new Reader($path);
    // $record = $reader->city('60.243.87.72');
    $record = $reader->city($_SERVER['HTTP_X_FORWARDED_FOR']); 

    /*
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
    */
    return $record;

}
/*

$ans = get_geoip();
echo "<pre>";
print_r($ans);
*/