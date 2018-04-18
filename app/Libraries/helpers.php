<?php

function UploadAuto($name = '', $path = '' ,$img = NULL, $thumb = '', $large = '')
{
    
    $ext = substr($img->getClientOriginalName(),strrpos($img->getClientOriginalName(), '.'));
    $photoName = MD5(microtime()).$ext;
    
    $img->move($path, $photoName);
    $result[$name] = $photoName;
    if($thumb!='')
    { // width thumb            
        $image = Intervention\Image\Image::make($path.'/'.$photoName)
                                                ->resize($thumb,null,true)
                                                ->save($path.'/_thumbs/'.str_replace($ext, '_'.$thumb.$ext ,$photoName), 60);
        $result['thumb'] = str_replace($ext, '_'.$thumb.$ext ,$photoName);                                                    
    }
    
    if($large!='')
    { // width large
        $image = Intervention\Image\Image::make($path.'/'.$photoName)
                                                ->resize($large,null,true)
                                                ->save($path.'/_larges/'.str_replace($ext, '_'.$large.$ext ,$photoName), 60);
        $result['large'] = str_replace($ext, '_'.$large.$ext ,$photoName);
    }
    return $result;
}

function GetRouteAdminResource($resource, $action = 'index')
{
    return 'admin.'.$resource.'.'.$action;
}

function GetViewAdminResource($resource, $action = 'index')
{
    return 'admin.'.$resource.'.'.$action;
}

function BuildOptionList($obj){
    $list = [];
    foreach ($obj as $key => $value) {
        $list[$value->id] = $value->name;
    }
    return $list;
}

function to_url($str)
{
    $str = stripUnicode($str);
    $str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');
    $str = trim($str);
    $str = preg_replace('/[^a-zA-Z0-9\ ]/','',$str); 
    $str = str_replace("  "," ",$str);
    $str = str_replace(" ","-",$str);
    return $str;
}

function stripUnicode($str)
{
    if(!$str) return false;
       $unicode = array(
         'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
         'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
         'd'=>'đ',
         'D'=>'Đ',
         'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
          'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
          'i'=>'í|ì|ỉ|ĩ|ị',   
          'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
         'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
          'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
         'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
          'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
         'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
         'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
       );
       foreach($unicode as $khongdau=>$codau) 
       {
            $arr=explode("|",$codau);
          $str = str_replace($arr,$khongdau,$str);
       }
    return $str;
}

function number_to_text_vn($num)
{
    $str = '';
    $num  = trim($num);

    $arr = str_split($num);
    $count = count( $arr );

    $f = number_format($num);
    //KHÔNG ĐỌC BẤT KÌ SỐ NÀO NHỎ DƯỚI 999 ngàn
    if ( $count < 7 ) {
        $str = $num;
    } else {
        // từ 6 số trở lên là triệu, ta sẽ đọc nó !
        // "32,000,000,000"
        $r = explode(',', $f);
        switch ( count ( $r ) ) {
            case 4:
                $str = $r[0] . ' tỉ';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' triệu'; }
                break;
            case 3:
                $str = $r[0] . ' triệu';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . 'nghìn'; }
                break;
        }
    }
    return ( $str . ' ' . UNIT );
}

function number_to_acreage_vn($num)
{
    $str = $num .' m2';
    return ( $str . ' ' . UNIT );
}

function removeImage($path){  
    if(file_exists(public_path($path))){
      unlink(public_path($path));
    }else{
      dd('File does not exists.');
    }
}