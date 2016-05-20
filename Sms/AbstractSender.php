<?php

namespace OCSoftwarePL\SmsApiBundle\Sms;

//that class may not have sense...
abstract class AbstractSender
{
    //that's not the best place fot these....

    // success for out point of view...
    const STATUS_SUCCESS_DRAFT = 'DRAFT';
    const STATUS_SUCCESS_DELIVERED = 'DELIVERED';
    const STATUS_SUCCESS_SENT = 'SENT';
    const STATUS_SUCCESS_QUEUE = 'QUEUE';

    const STATUS_FAIL_UNDELIVERED = 'UNDELIVERED';
    const STATUS_FAIL_EXPIRED = 'EXPIRED';
    const STATUS_FAIL_FAILED = 'FAILED';

    //and some more... UNKNOWN PENDING ACCEPTED RENEWAL STOP

    public function isSendTrySuccess($status)
    {
        return in_array($status, [
            self::STATUS_SUCCESS_DRAFT,
            self::STATUS_SUCCESS_QUEUE,
            self::STATUS_SUCCESS_SENT,
            self::STATUS_SUCCESS_DELIVERED
        ]);
    }

    public function isSendTryFailed($status)
    {
        return !$this->isSendTryFailed($status);    
    }
}