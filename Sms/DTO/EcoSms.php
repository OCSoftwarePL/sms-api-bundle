<?php

namespace OCSoftwarePL\SmsApiBundle\Sms\DTO;


class EcoSms extends Sms
{
    public function __construct($phone, $msg)
    {
        parent::__construct($phone, $msg, 'ECO');
    }
}