<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Setting\Model\EmailTemplate;
use Mail;

class NewCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $case, $comment, $commentedBy;
    private $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($case, $comment, $commentedBy, $template)
    {
        $this->case = $case;
        $this->comment = $comment;
        $this->commentedBy = $commentedBy;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tamplate = $this->template;

        $subject= $tamplate->subject;
        $body = $tamplate->value;
        $key = ['%7B', '%7D'];
        $value = ['{', '}'];
        $body = str_replace($key, $value, $body);

        $key = ['{COMMENTED_BY}', 'http://{CASE_URL}','{CASE_URL}', '{COMMENT}','{CASE_TITLE}','{EMAIL_SIGNATURE}'];
        $value = [$this->commentedBy, route('case.show', $this->case->id),route('case.show', $this->case->id), $this->comment->comments, $this->case->title, config('configs.mail_signature')];
        $body = str_replace($key, $value, $body);


        return $this->view('mail_body')->with(["body" => $body])->subject($subject);

    }
}
