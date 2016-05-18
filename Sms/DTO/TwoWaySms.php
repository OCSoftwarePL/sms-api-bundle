<?php

namespace OCSoftwarePL\SmsApiBundle\Sms\DTO;

class TwoWaySms extends Sms
{
    public function __construct($phone, $msg, $callbackUrl = null)
    {
        parent::__construct($phone, $msg, $callbackUrl, '2way');
    }
}