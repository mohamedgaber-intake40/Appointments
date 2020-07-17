<?php

namespace App\Notifications;

use App\Enums\AppointmentStatus;
use App\Enums\UserType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentUpdatedNotification extends Notification
{
    use Queueable;
    private $appointment;
    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($appointment , $message)
    {
        $this->appointment = $appointment;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('appointments.show',$this->appointment->id);
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('Your Appointment has been updated.')
                    ->line($this->message)
                    ->action('View Appointment', $url)
                    ->line('Thank you for using our application!');
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
            'appointment_id' => $this->appointment->id,
			'appointment_pain' => $this->appointment->pain->title,
			'appointment_date' => $this->appointment->date->toDayDateTimeString(),
			'message' => $this->message
        ];
    }
}
