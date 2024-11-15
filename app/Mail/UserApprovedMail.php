<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $template;

    public function __construct(User $user)
    {
        $this->user = $user;

    
    }

    public function build()
    {
        if ($this->template) {
            return $this->subject($this->template->title)
                        ->view('emails.dynamic_template')
                        ->with([
                            'body' => $this->template->body,
                            'user' => $this->user,
                            'footer_text' => $this->template->footer_text,
                            'button' => $this->template->button,
                            'button_url' => $this->template->button_url,
                        ]);
        }

        // Fallback to default email template if dynamic template is not available
        return $this->subject('Account Approved')
                    ->view('emails.user_approved')
                    ->with(['user' => $this->user]);
    }
}
