<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $missingMeals;

    public function __construct(User $user, $missingMeals)
    {
        $this->user = $user;
        $this->missingMeals = $missingMeals;
    }

    public function build()
    {
        return $this->subject('【リマインダー】昨日の食事ログが未入力です')
                    ->view('emails.reminder')
                    ->with([
                        'user' => $this->user,
                        'missingMeals' => $this->missingMeals
                    ]);
    }
}
