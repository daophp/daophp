<?php

namespace Swift\Filesystem;

use SplFileInfo;
use Swift\Foundation\Exception\FileException;

/**
 * Class File
 * @package Swift\Filesystem
 */
class File extends SplFileInfo
{
    /**
     * @param $destination
     * @return File
     */
    public function move($destination)
    {
        set_error_handler(function ($type, $msg) use (&$error) {
            $error = $msg;
        });

        $path = pathinfo($destination, PATHINFO_DIRNAME);
        if (!is_dir($path) && !mkdir($path, 0777, true)) {
            restore_error_handler();
            throw new FileException(sprintf('Unable to create the "%s" directory (%s)', $path, strip_tags($error)));
        }

        if (!rename($this->getPathname(), $destination)) {
            restore_error_handler();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $destination, strip_tags($error)));
        }

        restore_error_handler();

        @chmod($destination, 0666 & ~umask());

        return new self($destination);
    }
}
