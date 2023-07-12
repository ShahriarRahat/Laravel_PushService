<?php

namespace Modules\PushService\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PushService extends Model
{
    use HasFactory;

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\PushService\Database\factories\PushServiceFactory::new();
    // }

    public function pushable()
    {
        return $this->morphTo();
    }
}
