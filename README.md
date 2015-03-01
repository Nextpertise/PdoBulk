PdoBulk - A PHP Pdo insert wrapper
==============================================
[![Build Status](https://travis-ci.org/Nextpertise/PdoBulk.svg?branch=master)](https://travis-ci.org/Nextpertise/PdoBulk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Nextpertise/PdoBulk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Nextpertise/PdoBulk/?branch=master)

Simple PHP helper class for working with bulk sets of data which needs to be imported in the database.

Installing
----------

The easiest way to install **PdoBulk** is to use [Composer](http://getcomposer.org/download/), the awesome dependency manager for PHP. Once Composer is installed, run `composer.phar require nextpertise/pdo-bulk` and composer will do all the hard work for you.

Usage
-----

If you are using the autoloader in Composer (or your framework ties into it), then all you need to do is add a `use PdoBulk\pdoBulk;` statement at the top of each file you wish to use **PdoBulk** in and use it like a normal class:

```php
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

// pass pdo $conn to pdoBulk
$pdoBulk = new pdoBulk($conn);		
```

**Add a two entries**

```php

// Add entry 1 into `Package`
$packageEntry = array();
$packageEntry['name'] = 'wget';
$packageEntry['description'] = 'retrieves files from the web';
$packageEntry['architecture'] = 'amd64';
$pdoBulk->persist('Package', $packageEntry);

// Add entry 2 into `Package`
$packageEntry = array();
$packageEntry['name'] = 'curl';
$packageEntry['description'] = 'retrieves files from the web';
$packageEntry['architecture'] = 'amd64';
$pdoBulk->persist('Package', $packageEntry);

// Flush records to the database
$pdoBulk->flushQueue('Package');
```
