<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
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
    protected $table = 'districts';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
    	'province_id',
    	'name',
    	'type',
        'description',
    	'lat',
    	'lng',
    	'index'
    ];

    /**
     * Rules for create/edit.
     *
     * @var array
     */
    public $rules = [
    	'province_id',
    	'name',
    	'type'
    ]; 

    /**
     * Get the wards for the district.
     */
    public function wards(){
    	return $this->hasMany('App\Models\Ward');
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
