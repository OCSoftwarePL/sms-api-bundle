<?php

namespace OCSoftwarePL\SmsApiBundle\Sms\DTO;

class Sms
{
    public $phone;
    public $msg;
    public $callbackUrl;
    public $sender;

    public function __construct($phone, $msg, $callbackUrl = null, $sender = null)
    {
        $this->phone = $phone;
        $this->msg = $msg;
        $this->callbackUrl = $callbackUrl;
    }
}