<?php

namespace App\Jobs;

use App\Mail\NewCommentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\Setting\Model\EmailTemplate;

class NewCommentMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $case, $comment, $commentedBy, $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $case, $comment, $commentedBy)
    {
        $this->email = $email;
        $this->case = $case;
        $this->comment = $comment;
        $this->commentedBy = $commentedBy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template = EmailTemplate::where('type', 'new_case_comment')->where('status', 1)->first();
        if ($template){
            Mail::to($this->email)->send(new NewCommentMail($this->case, $this->comment, $this->commentedBy, $template));
        }
    }
}
