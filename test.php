<?php

require_once "vendor/autoload.php";

use Rootscratch\Ratelimit\Deploy;
new Deploy(5, 10, 'html');

