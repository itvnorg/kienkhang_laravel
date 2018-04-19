<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    // Allow fillable all fields. 
    protected $guarded = array();
    
   	public static function getSettingsKeyValue(){
   		$settings = [];
   		$model = SystemSetting::where('is_hidden','!=',1)->get();

        foreach($model as $settingItem)
        {
            $key = $settingItem->key;
            $dataType = $settingItem->data_type;
            $value = $settingItem->value;
            switch (strtolower($dataType)) {
                case 'integer':
                    $value = (int)$value;
                    break;
                case 'numeric':
                    $value = (double)$value;
                    break;
                case 'string':
                
                    break;
                case 'html':
                
                    break;
                case 'json':
                    $value = json_decode($value);
                    break;
                default:
                    
                    break;
            }
            $settings[$key] = $value;
        }
   		return $settings;
   	}

    public static function getSettings(){
        $settings = SystemSetting::get();
        return $settings;
    }
}
