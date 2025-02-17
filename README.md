
# SessionBased-Ratelimit-PHP

SessionBased-Ratelimit-PHP is a lightweight, session-based rate-limiting solution for PHP applications. It helps protect your web application from excessive requests by implementing request throttling without relying on external databases like Redis.

- https://packagist.org/packages/rootscratch/ratelimit

## Features

- Customizable request limits and time windows.
- Customizable error display

## Installation
```bash
composer require rootscratch/ratelimit
```

## Usage/Examples
```php
<?php

require_once "vendor/autoload.php";

use Rootscratch\Ratelimit\Deploy;
new Deploy(request_limit: 5, timeframe: 10, error_type: 'html');

//OR
//new Rootscratch\Ratelimit\Deploy(request_limit: 5, timeframe: 10, error_type: 'html');
```

### Error Display Types
- HTML `html`
- JSON `json`
