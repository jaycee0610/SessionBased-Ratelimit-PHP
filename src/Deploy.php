<?php

namespace Rootscratch\Ratelimit;

class Deploy
{

    public $request_limit;
    public $timeframe;
    public $error_type;

    public function __construct($request_limit = 1, $timeframe = 5, $error_type = 'json')
    {

        if (!session_id()) {
            session_start();
        }

        $this->request_limit = $request_limit;
        $this->timeframe = $timeframe;
        $this->error_type = $error_type;

        $this->enforce();
    }

    public function enforce()
    {
        if (!isset($_SESSION['rate_limit'])) {
            $_SESSION['rate_limit'] = [
                'count' => 0,
                'expires' => time() + $this->timeframe
            ];
        }

        // Reset if time expired
        if (time() > $_SESSION['rate_limit']['expires']) {
            $_SESSION['rate_limit'] = [
                'count' => 0,
                'expires' => time() + $this->timeframe
            ];
        }

        // Check request count
        if ($_SESSION['rate_limit']['count'] >= $this->request_limit) {
            if ($this->error_type === 'json') {
                die($this->error_json());
            }

            if ($this->error_type === 'html') {
                die($this->error_html());
            }
        }

        // Increase count and allow request
        $_SESSION['rate_limit']['count']++;
    }

    public function error_json()
    {
        header('HTTP/1.1 429 Too Many Requests');
        return json_encode(['error' => 'Too many requests. Try again later.'], JSON_PRETTY_PRINT);
    }

    public function error_html()
    {
        header('HTTP/1.1 429 Too Many Requests');
        return "<!doctypehtml><title>429 - Too Many Requests</title><style>body{text-align:center;font-family:Arial,sans-serif;margin:0;padding:20px}.title{font-size:36px;margin-bottom:10px}.description{font-size:18px;opacity:.8}</style><h1 class=title>429 Too Many Requests</h1><p class=description>You have been temporarily blocked due to excessive requests. Please try again later.";
    }
    
}
