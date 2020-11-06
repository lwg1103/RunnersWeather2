<?php

namespace App\Logger;

interface IApiCallLogger 
{
    public function log(float $lat, float $long);
}
