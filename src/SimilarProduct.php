<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class SimilarProduct extends Model
{
    protected $fillable = ['product_id', 'product_similar_id'];

    public function product()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Product', 'product_similar_id');
    }
}
