<?php

namespace App\Common\Delegate;

use App\Common\Filters\MailFilters;
use App\Common\Model\UserMail;
use App\Common\Model\Thread;
use App\Common\Constants\ApplicationCommonConsts;

class MailsDelegate
{
    /**
     * @param $mail \App\Common\Model\Mail
     * @param $toReceivers
     * @return array
     */
    public function sendMail($mail, $toReceivers)
    {
        $results = [
            'success_count' => 0,
            'errors' => []
        ];

        try {
            if ($mail->thread_id == ApplicationCommonConsts::$MAIL_THREAD_DEFAULT) {
                $thread = new Thread();

                $thread->save();

                $mail->thread_id = $thread->id;
            }
        }
        catch(\Exception $exception) {
            throw $exception;
        }

        // luu vao bang mail
        try {
            $mail->save();

            // luu nhieu item vao user_mail
            foreach ($toReceivers as $receiver) {
                try {
                    $mail->addMailDetail([
                        'sender_id' => $mail->sender_id,
                        'receiver_id' => $receiver,
                        'sent_date' => $mail->sent_date,
                        'title' => $mail->title,
                    ]);
                    $results['success_count']++;
                } catch (\Exception $exception) {
                    throw $exception;
                    $results['errors'][] = $receiver;
                    continue;
                }
            }
        } catch (\Exception $exception) {
            throw $exception;
//            $results = [
//                'successCount' => 0,
//                'errors' => $toReceivers
//            ];
        }

        return $results;
    }

    /**
     * @param $filter: destination, mark, dateFrom, dateTo, username, phrase
     * @return array UserMail
     */
    public function getMailBox(MailFilters $mailFilters) {
        $mailBox = UserMail::filter($mailFilters);

        // $mailBox = $mailBox->with(['sender' => function ($query) {
        //                 $query->select('username');
        //             }]);

        $mailBox = $mailBox->get();

        return $mailBox;
    }

    // public function getMailThread($userId, $thread) {
    //     $query = UserMail::where('sender_id', $userId)
    //                 ->where('receiver_id', $userId)
    //                 ->whereHas('mail', function($query) use ($thread) {
    //                     $query->where('thread', $thread);
    //                 });

    //     return $query->get();
    // }

    public function getMailThread($userId, $thread) {
        $query = Mail::where('thread', $thread)
                    ->whereHas('listSent', function($query) use ($userId) {
                        $query->where('sender_id', $userId)
                                ->orWhere('receiver_id', $userId);
                    });

        return $query->get();
    }
}