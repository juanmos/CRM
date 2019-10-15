<?php 

namespace App\Http;


use Illuminate\Foundation\Bus\DispatchesJobs;
// use Edujugon\PushNotification\PushNotification;
use App\Models\User;
use App\Notifications\TareaProximaNotification;
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
    public static function sendPush($id){
        $user=User::find($id);
        $user->notify(new TareaProximaNotification);
        // if($user->token_and !=null){
        //     $push= PushNotification::setService('fcm')
        //         ->setMessage([
        //                 'notification' => [
        //                         'title'=>'This is the title',
        //                         'body'=>'This is the message',
        //                         'sound' => 'default'
        //                         ],
        //                 'data' => [
        //                         'extraPayLoad1' => 'value1',
        //                         'extraPayLoad2' => 'value2'
        //                         ]
        //                 ])        
        //         ->setDevicesToken($user->token_and)
        //         ->send()
        //         ->getFeedback();
        // }
        // if($user->token_ios!=null){
        //     $push= PushNotification::setService('apn')
        //         ->setMessage([
        //             'aps' => [
        //                 'alert' => [
        //                     'title' => 'This is the title',
        //                     'body' => 'This is the body'
        //                 ],
        //                 'sound' => 'default',
        //                 'badge' => 1

        //             ],
        //             'extraPayLoad' => [
        //                 'custom' => 'My custom data',
        //             ]
        //         ])
        //         ->setDevicesToken($user->token_ios)
        //         ->send()
        //         ->getFeedback();
        // }
        
        
        // var_dump( $push);
    }
}