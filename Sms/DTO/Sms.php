<?php

namespace OCSoftwarePL\SmsApiBundle\Sms\DTO;


class Sms
{
    public $phone;
    public $msg;
    public $sender;

    public function __construct($phone, $msg, $sender = null)
    {
        $this->phone = $phone;
        $this->msg = $msg;
    }
}