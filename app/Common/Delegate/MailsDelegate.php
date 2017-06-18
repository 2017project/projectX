<?php

namespace App\Common\Delegate;

use App\Common\Constants\ApplicationCommonConsts;

class MailsDelegate
{
    /**
     * @param $mail App\Common\Model\Mail
     * @param $toReceivers
     * @return array
     */
    public function sendMail($mail, $toReceivers)
    {
        $results = [
            'successCount' => 0,
            'errors' => []
        ];
        // luu vao bang mail
        try {
            $mail->save();

            // luu nhieu item vao user_mail
            foreach ($toReceivers as $receiver) {
                try {
                    $mail->listSent()->create([
                        'sender_id' => $mail->sender_id,
                        'receiver_id' => $receiver,
                        'send_date' => $mail->send_date,
                        'title' => $mail->title,
                    ]);
                    $results['successCount']++;
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
}