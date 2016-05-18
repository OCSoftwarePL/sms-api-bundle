<?php

namespace OCSoftwarePL\SmsApiBundle\Sms\DTO;

class EcoSms extends Sms
{
    public function __construct($phone, $msg, $callbackUrl = null)
    {
        parent::__construct($phone, $msg, $callbackUrl, 'ECO');
    }
}