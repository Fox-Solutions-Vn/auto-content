<?php

namespace FoxSolution\AutoContent\Http\Controllers;

use FoxSolution\AutoContent\Actions\Traits\AutoContentGenerate;
use FoxSolution\AutoContent\Actions\Traits\AutoContentSettings;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;

class AutoContentController extends BaseController
{
    use AutoContentSettings;
    use AutoContentGenerate;

    public function __construct(
        protected Request $request,
        protected BaseHttpResponse $response
    ) {
    }
}
