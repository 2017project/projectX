<?php

namespace App\Common\Transformers;
use App\Common\Constants\TransformConsts;

class MailBoxTransformer extends Transformer
{
    protected $resourceName = 'mailbox';

    public function transform($data, $option = null)
    {
        if ($option == TransformConsts::$MAIL_TYPE['BASIC']) {
            return [
                'username' => $this->getValueForKey($data, 'sender.username'),
                'title' => $this->getValueForKey($data, 'title'),
                'sent_date' => $this->getValueForKey($data, 'sent_date')
            ];
        }
        else {
            return [
                'mail_id' => $this->getValueForKey($data, 'mail_id'),
                // 'username' => $this->getValueForKey($data, 'sender.username'),
                'title' => $this->getValueForKey($data, 'title'),
                'sent_date' => $this->getValueForKey($data, 'sent_date'),
                'type' => $this->getValueForKey($data, 'type'),
                'mark' => $this->getValueForKey($data, 'mark'),
                'thread_id' => $this->getValueForKey($data, 'thread_id')
            ];
        }
    }
}