<?php

namespace App\Mail;


use App\Models\User\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


/**
 * Class SendWelcomeEmail
 *
 * @extends  Mailable
 * @category Mail
 * @package  App\Mail

 */
class SendWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;

    /**
     * @var Role
     */
    public Role $role;

    /**
     * @var string
     */
    public string $entityName;


    /**
     * @param User        $user
     * @param Role        $role
     */
    public function __construct(User $user, Role $role)
    {
        $this->user        = $user;
        $this->role        = $role;
        $this->entityName = '';


    }//end __construct()


    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido a Lazo',
        );

    }//end envelope()


    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.welcome',
        );

    }//end content()


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];

    }//end attachments()


}//end class
