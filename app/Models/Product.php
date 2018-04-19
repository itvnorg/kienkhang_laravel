<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Direction;
use App\Models\User;

class Product extends Model
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
    protected $table = 'products';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
    	'category_id',
    	'province_id',
    	'district_id',
    	'ward_id',
    	'title',
    	'url_rewrite',
        'type',
    	'price',
    	'acreage',
    	'rooms',
    	'direction_id',
    	'address',
    	'lat',
    	'lng',
    	'description',
    	'content',
    	'views',
    	'status',
    	'index',
        'created_by',
        'updated_by'
    ];

    /**
     * Rules for create/edit.
     *
     * @var array
     */
    public $rules = [
    	'category_id',
    	'title',
        'type'
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(){
    	return $this->belongsTo('App\Models\ProductCategory', 'category_id');
    }

    /**
     * Get the images for the product.
     */
    public function images(){
    	return $this->hasMany('App\Models\ProductImage');
    }

    /**
     * Get list records of this model.
     *
     * @var array
     */
    public function getList($input, $user = null){
        $list = $this->select('*');
        if(isset($input['searchString'])){
            $list->where('name', 'like', '%'.$input['searchString'].'%');
        }
        if($user != null){
            $list->where('created_by', $user->id);
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
    public function countTotal($input, $user = null){
        $total = $this->select('id');
        if(isset($input['searchString'])){
            $total->where('name', 'like', '%'.$input['searchString'].'%');
        }
        if($user != null){
            $total->where('created_by', $user->id);
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

            if(isset($data->created_by)){
                $data['post_by'] = User::find($data->created_by);
                $data['post_by']['full_name'] = $data['post_by']['first_name'].' '.$data['post_by']['last_name'];
            }

            $data['images'] = $data->images;
            $data['relates'] = $this->where('category_id', $data->category->id)->orderBy('created_at', 'desc')->offset($data->id)->limit(5)->get();
            foreach ($data['relates'] as $key => $value) {
                $data['relates'][$key]['category'] = $value->category;
            }
        }

        return $data;
    }
}
