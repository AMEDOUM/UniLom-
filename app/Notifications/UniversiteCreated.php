<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UniversiteCreated extends Notification
{
    use Queueable;
    
    public $universite;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $universite)
    {
        $this->universite = $universite;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle université à valider')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle université vient de s\'inscrire et attend votre validation.')
            ->line('**Université:** ' . $this->universite->nom_universite)
            ->line('**Email:** ' . $this->universite->email)
            ->line('**Téléphone:** ' . ($this->universite->telephone ?? 'Non renseigné'))
            ->line('**Localisation:** ' . ($this->universite->localisation ?? 'Non renseignée'))
            ->action('Valider l\'université', url('/admin/utilisateurs/' . $this->universite->id . '/edit'))
            ->line('Merci d\'avoir confiance en UniLomé !');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'universite_id' => $this->universite->id,
            'nom' => $this->universite->nom_universite,
            'email' => $this->universite->email,
            'message' => 'Une nouvelle université vient de s\'inscrire',
        ];
    }
}
