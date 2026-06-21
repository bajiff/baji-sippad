<?php

namespace App\Notifications;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PendaftaranStatusNotification extends Notification
{
    use Queueable;

    protected $pendaftaran;

    /**
     * Create a new notification instance.
     *
     * @param Pendaftaran $pendaftaran
     */
    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $judulPelatihan = $this->pendaftaran->pelatihan->judul;
        $status = $this->pendaftaran->status;
        $message = "Pendaftaran Anda untuk pelatihan \"{$judulPelatihan}\" telah " . ($status === 'disetujui' ? 'disetujui oleh Admin.' : 'ditolak oleh Admin.');

        return [
            'pendaftaran_id' => $this->pendaftaran->id,
            'pelatihan_id' => $this->pendaftaran->pelatihan_id,
            'pelatihan_title' => $judulPelatihan,
            'status' => $status,
            'message' => $message,
            'url' => route('user.pendaftaran.index'),
        ];
    }
}
