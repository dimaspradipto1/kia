<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class KiaNotification extends Notification
{
    public function __construct(
        public string $tipe,
        public string $judul,
        public string $pesan,
        public ?string $link = null,
        public string $icon = 'bi-bell'
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'tipe'  => $this->tipe,
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'link'  => $this->link,
            'icon'  => $this->icon,
        ];
    }
}
