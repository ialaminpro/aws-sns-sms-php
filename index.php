<?php

/** Error Debugging */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);

/** Make sure to add autoload.php */
require './vendor/autoload.php';

/** Aliasing the classes */

use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;


/** AWS SNS Access Key ID */
$access_key_id    = 'XXX';

/** AWS SNS Secret Access Key */
$secret = 'XXX';

/** Create SNS Client By Passing Credentials */
$SnSclient = new SnsClient([
    'region' => 'ap-south-1',
    'version' => 'latest',
    'credentials' => [
        'key'    => $access_key_id,
        'secret' => $secret,
    ],
]);

/** Message data & Phone number that we want to send */
$message = 'Testing AWS SNS Messaging';

/** NOTE: Make sure to put the country code properly else SMS wont get delivered */
$phone = '+917019102XXX';

try {
    /** Few setting that you should not forget */
    $result = $SnSclient->publish([
        'MessageAttributes' => array(
            /** Pass the SENDERID here */
            'AWS.SNS.SMS.SenderID' => array(
                'DataType' => 'String',
                'StringValue' => 'StackCoder'
            ),
            /** What kind of SMS you would like to deliver */
            'AWS.SNS.SMS.SMSType' => array(
                'DataType' => 'String',
                'StringValue' => 'Transactional'
            )
        ),
        /** Message and phone number you would like to deliver */
        'Message' => $message,
        'PhoneNumber' => $phone,
    ]);
    /** Dump the output for debugging */
    echo '<pre>';
    print_r($result);
    echo '<br>--------------------------------<br>';
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage() . "<br>";
}