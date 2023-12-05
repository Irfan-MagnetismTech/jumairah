<?php

namespace App\Notifications;

use App\Mail\SalesCollectionMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class SalesCollectionNotificiation extends Notification Implements ShouldQueue
{
    use Queueable;
    public $salesCollection;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($salesCollection)
    {
        $this->salesCollection = $salesCollection;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $cc = ['rayhan@ranconfc.com.bd','imtiaz@ranconfc.com.bd'];

        return (new \Illuminate\Notifications\Messages\MailMessage)
        ->subject('Payment was received.')
        ->markdown('emails.salescollectionmail', ['salesCollection' => $this->salesCollection])->cc($cc);
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
            'Subject' => "Payment Received",
            'Collection ID' => $this->salesCollection->id,
            'Received Date' => $this->salesCollection->received_date,
            'Received Amount' => $this->salesCollection->received_amount,
        ];
    }
    public function toNexmo($notifiable)
    {
        $client = $this->salesCollection->sell->client->name;
        $amount = $this->salesCollection->received_amount;
        $inWord = $this->salesCollection->receivedAmountInwords;
        $paymentMode = $this->salesCollection->payment_mode;
        $receivedDate = $this->salesCollection->received_date;
        foreach($this->salesCollection->salesCollectionDetails as $salesCollectionDetail){
            $salesCollectionDetail->particular;
            $salesCollectionDetail->installment_no ? "-$salesCollectionDetail->installment_no" : null;
        }
        $project = $this->salesCollection->sell->apartment->project->name;
        $apartment = $this->salesCollection->sell->apartment->name;

        return (new NexmoMessage())
//            ->content('Payment Received Successfully')
            ->content("Received with Thanks from $client, amount of Tk. $amount/- (Taka $inWord Only),through $paymentMode, Dated on- $receivedDate,Project Name- $project, Apt. ID- $apartment, Purpose- 2nd Installment.");
    }


}
