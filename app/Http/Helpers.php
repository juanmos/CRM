<?php 

namespace App\Http;


use Illuminate\Foundation\Bus\DispatchesJobs;
// use Edujugon\PushNotification\PushNotification;
use App\Models\User;
use App\Notifications\TareaProximaNotification;
use App\Notifications\VisitaProximaNotification;
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
        $user->notify(new TareaProximaNotification(1));
    }
    public static function sendVisita($id){
        $user=User::find($id);
        $user->notify(new VisitaProximaNotification(1));
    }
}