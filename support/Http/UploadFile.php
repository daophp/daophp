<?php

namespace Swift\Http;

use Swift\Filesystem\File;

/**
 * Class UploadFile
 * @package Swift\Http
 */
class UploadFile extends File
{
    /**
     * @var string
     */
    protected $_uploadName = null;

    /**
     * @var string
     */
    protected $_uploadMimeType = null;

    /**
     * @var int
     */
    protected $_uploadErrorCode = null;

    /**
     * UploadFile constructor.
     * @param $file_name
     * @param $upload_name
     * @param $upload_mime_type
     * @param $upload_error_code
     */
    public function __construct($file_name, $upload_name, $upload_mime_type, $upload_error_code)
    {
        $this->_uploadName = $upload_name;
        $this->_uploadMimeType = $upload_mime_type;
        $this->_uploadErrorCode = $upload_error_code;
        parent::__construct($file_name);
    }

    /**
     * @return string
     */
    public function getUploadName()
    {
        return $this->_uploadName;
    }

    /**
     * @return string
     */
    public function getUploadMineType()
    {
        return $this->_uploadMimeType;
    }

    /**
     * @return mixed
     */
    public function getUploadExtension()
    {
        return pathinfo($this->_uploadName, PATHINFO_EXTENSION);
    }

    /**
     * @return int
     */
    public function getUploadErrorCode()
    {
        return $this->_uploadErrorCode;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->_uploadErrorCode === UPLOAD_ERR_OK;
    }
}
