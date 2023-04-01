<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FullName;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    //

   public function saveName(Request $request)
   {$start_time = microtime(true);
        $result=FullName::create([
            'fname'=>$request->fname,
            'lname'=>$request->lname,
         ]);
         $end_time = microtime(true);
         $execution_time = $end_time - $start_time;
         FullName::find($result->id)->update(['execution_time'=>$execution_time]);
         return view('welcome', ['result' => $result,'execution_time'=>$execution_time]);
   }



   public function findIpAddres()
   {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];
        $result = array('country' => '', 'city' => '');
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if ($ip_data && $ip_data->geoplugin_countryName != null) {

            $result['country'] = $ip_data->geoplugin_countryCode;
            $result['city'] = $ip_data->geoplugin_city;

            Cookie::queue('country',$ip_data->geoplugin_countryCode);
            Cookie::queue('city',$ip_data->geoplugin_city);
        }
        return view('welcome',['result' => $result]);

   }


   public function getjsonfile()
   {
    $temp=[];
    $data = @json_decode(file_get_contents("https://opencontext.org/query/Asia/Turkey/Kenan+Tepe.json"),true);  
 
    $result=$this->findValuesByKey($data,"id");
    print_r($result);



   }

  public function findValuesByKey($obj, $key) {
    $values = array();
    foreach ($obj as $property => $value) {
        if ($property == $key) {
            $values[] = $value;
        }
        if (is_object($value) || is_array($value)) {
            $values = array_merge($values, $this->findValuesByKey($value, $key));
        }
    }
    return $values;
}




}
