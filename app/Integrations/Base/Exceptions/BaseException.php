<?php

namespace App\Integrations\Base\Exceptions;

use Exception;
use App\Integrations\Base\Interfaces\BaseThrowableInterface;

class BaseException extends Exception implements BaseThrowableInterface
{

}
