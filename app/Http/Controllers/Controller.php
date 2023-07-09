<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // image upload 
    public function imageUpload($request, $name, $directory)
    {
        $doUpload = function ($image) use ($directory) {
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extention = $image->getClientOriginalExtension();
            $imageName = $name . '_' . uniqId() . '.' . $extention;
            $image->move($directory, $imageName);

            // Image::make($this)->resize(100, 200, function ($constraint) {
            //     $constraint->aspectRatio();
            // });

            return $directory . '/' . $imageName;
        };
        if (!empty($name) && $request->hasFile($name)) {
            $file = $request->file($name);
            if (is_array($file) && count($file)) {
                $imagesPath = [];
                foreach ($file as $key => $image) {
                    $imagesPath[] = $doUpload($image);
                }
                return $imagesPath;
            } else {
                return $doUpload($file);
            }
        }

        return false;
    }
    //

    public function createThumbnail($path, $width, $height)
    {
    }

    public function invoiceGenerate($model, $prefix = '')
    {
        // $date = '2021-10-28 12:27:41';


        // if($model->$date == Carbon::today() ){
        //     $code = "00001";
        //     $model = '\\App\\Models\\' . $model;
        //         $newCode = + 1;
        //         $zeros = ['0', '00', '000', '0000','00000'];
        //         $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        //     return $prefix . $code;
        // }else{


        //     $code = "000001";
        //     $model = '\\App\\Models\\' . $model;
        //     $num_rows = $model::count();
        //     if ($num_rows != 0) {
        //         $newCode = $num_rows + 1;
        //         $zeros = ['0', '00', '000', '0000','00000'];
        //         $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        //     }
        //     return $prefix . $code;
        // }


        // $code = "000001";
        // $model = '\\App\\Models\\' . $model;
        // $num_rows = $model::count();
        // if ($num_rows != 0) {
        //     $newCode = $num_rows + 1;
        //     $zeros = ['0', '00', '000', '0000','00000'];
        //     $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        // }
        // return $prefix . $code;

    }





    public function generateCode($model, $prefix = '')
    {
        $code = "000001";
        $model = '\\App\\Models\\' . $model;
        $num_rows = $model::count();
        if ($num_rows != 0) {
            $newCode = $num_rows + 1;
            $zeros = ['0', '00', '000', '0000', '00000'];
            $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
        }
        return $prefix . $code;
    }



     // sms sender
     public function send_sms($mobileNumber, $message) 
     {
         $url = "http://esms.linktechbd.com/smsapi";
 
         $data = [
           "api_key" => "C200880461545485ecff43.36078232",
           "type" => "unicode",
           "contacts" => $mobileNumber,
           "senderid" => "MasrangaSSL",
           "msg" => $message,
         ];
 
         $ch = curl_init();
 
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         
         $response = curl_exec($ch);
 
         curl_close($ch);
 
         $errorCodes = [1002, 1003, 1004, 1005, 1006, 1007, 1008, 1009, 1010, 1011, 1012, 1013, 1014];
 
         if (in_array($response, $errorCodes)) {
 
             return false;
         }
 
         return true;
     }


 
 
}
