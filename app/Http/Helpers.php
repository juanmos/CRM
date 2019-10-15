<?php 

namespace App\Http;


use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\User;
use Carbon\Carbon;
use PushNotification;
use Redirect;
use Geotools;
use JWTAuth;
use Auth;
use Mail;
use Config;   

class Helpers{
    use DispatchesJobs;
    public static function randomPassword() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 64; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function nuevoPassword() {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function sendPush(){
        $user=User::find(4);
        echo $user->token_and;
        $push= new PushNotification('gcm');
        $push->setMessage([
            'notification' => [
                    'title'=>'This is the title',
                    'body'=>'This is the message',
                    'sound' => 'default'
                    ],
            'data' => [
                    'extraPayLoad1' => 'value1',
                    'extraPayLoad2' => 'value2'
                    ]
            ])
            ->setService('gcm')
            ->setDevicesToken([$user->token_and])->send()->getFeedback();;
        return $push;
    }
}