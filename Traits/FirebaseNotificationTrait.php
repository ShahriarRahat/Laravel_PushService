<?php
namespace Modules\PushService\Traits;

trait FirebaseNotificationTrait
{
    function sendChannelFirebaseNotification($channel, $notification_type='announcement', $id = null, $url='notifications',$title,$body,$image=null)
    {
        try {

            $SERVER_API_KEY=env('FIREBASE_API_KEY');
            if(!$SERVER_API_KEY){
                return false;
            }else{
                $data = [
                    "to" => '/topics/'.$channel,
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                        "url" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "image" => $image,
                    ],
                    "aps" => [
                        "title" => $title,
                        "body" => $body,
                        "badge" => "1",
                        "click_action" => $url,
                        "id" => $id,
                        "type" => $notification_type,
                        "sound" => "default",
                        "image" => $image,
                        "content_available" => true,
                        "priority" => "high",
                    ],
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
                return $response;
            }

        } catch (\Throwable $th) {
            return false;
        }
    }
}
