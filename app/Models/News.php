<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
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
    protected $table = 'news';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
    	'category_id',
        'photo',
    	'title',
    	'url_rewrite',
    	'content',
    	'description',
    	'views',
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
    	'title'
    ]; 

    /**
     * Get the category that owns the product.
     */
    public function category(){
    	return $this->belongsTo('App\Models\NewsCategory', 'category_id');
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

    /**
     * Get item detail of this model.
     *
     * @var array
     */
    public function getDetail($url_rewrite){
        $data = $this->where('url_rewrite', '=', $url_rewrite)->firstOrFail();
        if(isset($data)){
            $data['category'] = $data->category;
            if(isset($data->direction_id)){
                $data['direction'] = Direction::find($data->direction_id);
            }

            $data['relates'] = $this->where('category_id', $data->category->id)->orderBy('created_at', 'desc')->offset($data->id)->limit(10)->get();
            foreach ($data['relates'] as $key => $value) {
                $data['relates'][$key]['category'] = $value->category;
            }
        }

        return $data;
    }
}
