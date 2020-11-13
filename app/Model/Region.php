<?php

namespace App\Model;

use Swift\Database\Model;

/**
 * Class Region
 * @package App\Model
 */
class Region extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'region';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'region_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}