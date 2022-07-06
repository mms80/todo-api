<?php

use mms80\TodoApi\Http\Middleware\ApiAuthorization;

return [
    "middleware" => ["api", ApiAuthorization::class],
];