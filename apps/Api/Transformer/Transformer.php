<?php

namespace App\Api\Transformer;

/**
 * Class Transformer
 * @package App\Api\Transformer
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
