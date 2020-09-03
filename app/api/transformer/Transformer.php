<?php

namespace app\api\transformer;

/**
 * Class Transformer
 * @package app\api\transformer
 */
abstract class Transformer
{
    /**
     * @param $data
     * @return array
     */
    public function transformCollection($data)
    {
        return array_map([$this, 'transform'], $data);
    }

    /**
     * @param $item
     * @return mixed
     */
    abstract public function transform($item);
}
