<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BillNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param array<string, mixed> $billData
     */
    public function __construct(protected array $billData)
    {
    }

    /**
     * @param mixed $notifiable
     * @return array<string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Cobrança gerada!')
            ->greeting('Olá ' . $notifiable->name)
            ->line('Cobrança #'.$this->billData['id'].' gerada com sucesso!')
            ->line('Valor R$ ' . number_format($this->billData['amount'], 2, ",", "."))
            ->salutation('At.te, Thiago Souza.');
    }
}
