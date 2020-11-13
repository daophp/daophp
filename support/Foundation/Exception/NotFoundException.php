<?php

namespace Swift\Foundation\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 * @package Swift\Foundation\Exception
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}
