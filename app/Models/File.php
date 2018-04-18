<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
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
    protected $table = 'files';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
    	'category_id',
    	'file_name',
    	'file_type',
    	'file_path',
    	'status',
    	'index'
    ];

    /**
     * Rules for create/edit.
     *
     * @var array
     */
    public $rules = [
    	'category_id',
    	'file_type'
    ]; 

    /**
     * Get the category that owns the product.
     */
    public function category(){
    	return $this->belongsTo('App\Models\FileCategory', 'category_id');
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
