<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Setting\Model\EmailTemplate;
use Mail;

class CaseAssignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assigneFrom, $case, $assigneTo;
    private $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assigneFrom,$case, $assigneTo, $template)
    {
        $this->assigneFrom = $assigneFrom;
        $this->case = $case;
        $this->assigneTo = $assigneTo;
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

        $key = ['{ASSIGNED_FROM}','http://{CASE_URL}','{CASE_URL}','{ASSIGNED_TO}','{CASE_TITLE}','{EMAIL_SIGNATURE}'];
        $value = [$this->assigneFrom->name, route('case.show', $this->case->id),route('case.show', $this->case->id), $this->assigneTo->name, $this->case->title,config('configs.mail_signature')];
        $body = str_replace($key, $value, $body);


        return $this->view('mail_body')->with(["body" => $body])->subject($subject);

    }
}
