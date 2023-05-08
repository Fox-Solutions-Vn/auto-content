<?php

namespace FoxSolution\AutoContent\Facades;

use FoxSolution\AutoContent\Contracts\OpenAiInterface;
use Illuminate\Support\Facades\Facade;

class OpenAiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OpenAiInterface::class;
    }
}
