<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class LookupModel extends Model
{
    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];
}
