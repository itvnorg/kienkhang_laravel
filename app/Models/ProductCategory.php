<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
    	'parent_id',
    	'name',
    	'url_rewrite',
    	'level',
        'description',
    	'status',
    	'index'
    ];

    /**
     * Rules for create/edit.
     *
     * @var array
     */
    public $rules = [
    	'name',
    	'description',
    	'status'
    ]; 

    /**
     * Get the districts for the province.
     */
    public function products(){
    	return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }

    public function getRules(){
        return $rules;
    }

    /**
     * Get list records of this model.
     *
     * @var array
     */
    public function getList($input){
        $list = $this->select('*');
        if(isset($input['searchString'])){
            $list->where('name', 'like', '%'.$input['searchString'].'%');
        }
        $list->offset($input['offset'])->limit($input['limit'])->orderBy('index', 'asc');

        $list = $list->get();
        return $list;
    }

    /**
     * Get count number of this model.
     *
     * @var array
     */
    public function countTotal($input){
        $total = $this->select('id');
        if(isset($input['searchString'])){
            $total->where('name', 'like', '%'.$input['searchString'].'%');
        }

        $total = $total->count();
        return $total;
    }
}
