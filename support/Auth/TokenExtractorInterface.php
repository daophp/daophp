<?php

namespace Swift\Auth;

/**
 * Interface TokenExtractorInterface
 * @package Swift\Auth
 */
interface TokenExtractorInterface
{
    /**
     * 提取token
     * @return string
     */
    public function extractToken();
}
