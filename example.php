<?php

namespace exampleApp;

require 'src/PdoBulk/PdoBulk.php';

use PdoBulk\pdoBulk;
use PdoBulk\pdoBulkSubquery;

// configuration
$dbhost 	= "localhost";
$dbname		= "dpkg";
$dbuser		= "user";
$dbpass		= "password";

// database connection
$conn = new \PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$pdoBulk = new pdoBulk($conn);		
$startime = time();

// Echo header
echo "recordcounter;seconds;memoryusageinbytes\n";

// Insert 1000 'packages'
for($i = 0; $i < 1000; $i++) {
	// Add `Package`
	$packageEntry = array();
	$packageEntry['name'] = 'wget_'.$i;
	$packageEntry['description'] = 'retrieves files from the web';
	$packageEntry['architecture'] = 'amd64';
	$pdoBulk->persist('Package', $packageEntry);
	
	// Add `Packageversion`
	$packageversionEntry['packageid'] = 
		new pdoBulkSubquery("(SELECT id FROM `Package` WHERE name = '" . $packageEntry['name'] . "' AND architecture = '" . $packageEntry['architecture'] . "')");
	$packageversionEntry['version'] = '1.13.4-3+deb7u2';
	$pdoBulk->persist('Packageversion', $packageversionEntry);
	
    if($i != 0 && $i % 100 == 0) {
		$pdoBulk->flushQueue('Package');
		$pdoBulk->flushQueue('Packageversion');
		echo $i . ';' . (time()-$startime) . ';'. memory_get_usage() . "\n";
	}
}
$pdoBulk->flushQueue('Package');
$pdoBulk->flushQueue('Packageversion');
echo $i . ';' . (time()-$startime) . ';'. memory_get_usage() . "\n";
