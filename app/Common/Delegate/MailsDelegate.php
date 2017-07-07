<?php

namespace App\Common\Delegate;

use App\Common\Filters\MailFilters;
use App\Common\Model\UserMail;

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
     * @param String userId
     * @param $filter: destination, mark, dateFrom, dateTo, username, phrase, itemsPerPage
     * @return array UserMail
     */
    public function getMailBox(MailFilters $mailFilters) {
        $mailBox = UserMail::filter($mailFilters);

        $mailBox = $mailBox->get();

        return $mailBox;
    }
}