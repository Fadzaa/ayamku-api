<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        $orderStatus = $this->status;

        $title = '';
        $body = '';

        if ($orderStatus === 'processing') {
            $title = 'Pesananmu sedang Diproses';
            $body = 'Pesananmu sedang diproses, mohon tunggu sebentar';
        } elseif ($orderStatus === 'completed') {
            $title = 'Pesananmu sudah Selesai';
            $body = 'Pesananmu telah selesai, silahkan ambil di pos yang kamu pilih';
        } elseif ($orderStatus === 'cancelled') {
            $title = 'Pesananmu Dibatalkan';
            $body = 'Pesananmu telah dibatalkan';
        }

        return (new FcmMessage(notification: new FcmNotification(
            title: $title,
            body: $body,
        )))
            ->data(['data1' => 'value', 'data2' => 'value2'])
            ->custom([
                'android' => [
                    'notification' => [
                        'color' => '#0A0A0A',
                        'sound' => 'default',
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default'
                        ],
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
            ]);
    }
}
