<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs;

    public const SUCCESS_MESSAGE = 'Request Processed Successfully';

    public const ERROR_MESSAGE = 'Unable to Process The Request. Please Try Agine ';

    public const SUCCESS_STATUS = 'success';

    public const ERROR_STATUS = 'error';
}
