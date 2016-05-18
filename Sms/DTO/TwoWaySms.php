<?php

namespace OCSoftwarePL\SmsApiBundle\Sms\DTO;


class TwoWaySms extends Sms
{
    public function __construct($phone, $msg)
    {
        parent::__construct($phone, $msg, '2way');
    }
}