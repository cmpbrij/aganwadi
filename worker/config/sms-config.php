<?php


function sendroutedSms($otp,$to) {
    $api_endpoint = 'https://app3.flash49.com/fe/api/v1/send?';

    $text = 'Your OTP to perform the action on AWW portal is ' . $otp . ' CMP Techsseract LLP';

    $data = [
        'username' => 'cmpsms.trans',
        'password' => 'jSEwD',
        'unicode' => 'false',
        'from' => 'CMPTLL',
        'to' => $to,
        'text' => $text,
        'dltContentId' => '1007849239056488561',
        'dltPrincipalEntityId' => '1001748124784888077'
    ];

    $url = $api_endpoint . http_build_query($data);

    return file_get_contents($url);
}

 

?>



