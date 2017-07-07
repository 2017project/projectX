<?php

namespace App\Common\Filters;

use Illuminate\Http\Request;
use App\Common\Constants\ApplicationCommonConsts;
use App\Common\Model\UserMail;

class MailFilters extends Filters {
    protected $filters = [
                'destination', 
                'mark', 
                'dateFrom',
                'dateTo',
                'username', 
                'phrase'
            ];

    protected function destination($destination) {
        $userId  = auth()->id();

        // Filter destination: inbox, outbox, or all        
        if ($destination == ApplicationCommonConsts::$MAIL_FILTER_DEST_INBOX) {
            $this->builder = UserMail::where('receiver_id', $userId);
        }
        else {
            if ($destination == ApplicationCommonConsts::$MAIL_FILTER_DEST_OUTBOX) {
                $this->builder = UserMail::where('sender_id', $userId);
            }
            else {
                $this->builder = UserMail::where('receiver_id', $userId)
                                    .orWhere('sender_id', $userId);
            }
        }
    }

    protected function mark($mark) {
        $this->builder = UserMail::where('mark', $mark);
    }

    protected function dateFrom($dateFrom) {
        $this->builder = UserMail::where('sent_date', '>=', $dateFrom);
    }

    protected function dateTo($dateTo) {
        $this->builder = UserMail::where('sent_date', '<=', $dateTo);
    }

    protected function username($username) {
        $this->builder = UserMail::whereHas('sender', function($query) use ($username) {
                $query->where('username', 'like', '%'.($username).'%');
            })->orWhereHas('receiver', function($query) use ($username) {
                $query->where('username', 'like', '%'.($username).'%');
            });
    }

    protected function phrase($phrase) {
        $this->builder = UserMail::where('title', 'like', '%'.($phrase).'%')
                            ->orWhereHas('mail', function($query) use ($phrase) {
                                $query->where('content', 'like', '%'.($phrase).'%');
                            });
    }
}