<?php

namespace App\Mail;

use App\Models\Incidencia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase que representa un correo electrónico para el envío de notificaciones sobre incidencias.
 *
 * Implementa la interfaz ShouldQueue para que el correo pueda ser encolado y procesado de forma asíncrona.
 */
class EnvioCorreo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param Incidencia $incidencia La incidencia asociada al correo.
     * @param string $operacion La operación asociada al correo.
     */
    public function __construct(private Incidencia $incidencia, private string $operacion)
    {
    }

    /**
     * Obtiene el sobre del mensaje.
     *
     * @return Envelope El sobre del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incidencias TIC - Avisos',
            cc: [env('MAIL_TO_CC')]
        );
    }

    /**
     * Obtiene la definición del contenido del mensaje.
     *
     * @return Content La definición del contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.email',
            with: [
                'operacion' => $this->operacion,
                'incidencia' => $this->incidencia,
            ],
        );
    }

    /**
     * Obtiene los adjuntos para el mensaje.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment> Lista de adjuntos.
     */
    public function attachments(): array
    {
        return [];
    }
}
