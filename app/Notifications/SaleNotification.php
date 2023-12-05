<?php

namespace App\Notifications;

use App\Mail\SellMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class SaleNotification extends Notification
{
    use Queueable;
    public $sell;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sell)
    {
        $this->sell = $sell;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new SellMail($this->sell));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'Subject' => "Intimacy Letter.",
            'Sell ID' => $this->sell->id,
            'Sell Date' => $this->sell->sell_date,
            'Total Value' => $this->sell->total_value,
        ];
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())->content("Congratulations!");
    }
}
