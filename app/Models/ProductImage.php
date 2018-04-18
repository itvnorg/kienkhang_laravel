<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
    	'product_id',
    	'photo',
    	'large',
    	'thumb'
    ];
}
