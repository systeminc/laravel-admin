<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'message',
        'approved',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Product')->withTrashed();
    }
}
