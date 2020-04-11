<?php
namespace App\Helpers;
use Mail;

/**
 *
 * @package     budbuddy
 * @subpackage  Helpers
 * @author      asharma
 */
class HelperService {

    /**
     * send mail
     * @param array $body
     * @param string $to
     * @return int
     */
    public function sendEmail(array $body, $to,$fileName,$file = [] ) {
        info( 'Processing send email request' );
        Mail::send($fileName , $body, function ( $message ) use ($body, $to, $file) {
            $message->to( $to );
            $message->subject( $body['subject'] );
        });
        $failed = count(Mail::failures());
        info( 'Send email request completed, sent_status: '.($failed == 0 ? 'Y' : 'N') );
        return ($failed == 0 ? 1 : 0);
    }

    /**
     * calculate latitude and longitude
     * @param string $address
     * @return array
     */
    public function get_lat_long($address) {
        $array = array();

        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.config('budbuddy.geocode-key'));

        //JSON to an array
        $geo = json_decode($geo, true);
        if ($geo['status'] = 'OK') {
            $latitude = !empty($geo['results'])?$geo['results'][0]['geometry']['location']['lat']:NULL;
            $longitude = !empty($geo['results'])?$geo['results'][0]['geometry']['location']['lng']:NULL;

            $array = array('lat'=> $latitude ,'lng'=>$longitude);
        }
        return $array;
    }

}