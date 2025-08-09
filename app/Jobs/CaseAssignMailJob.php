<?php

namespace App\Jobs;

use App\Mail\CaseAssignMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\Setting\Model\EmailTemplate;

class CaseAssignMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $assigneFrom, $case, $assigneTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assigneFrom, $case, $assigneTo)
    {
        $this->assigneFrom = $assigneFrom;
        $this->case = $case;
        $this->assigneTo = $assigneTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template = EmailTemplate::where('type', 'case_assign')->where('status', 1)->first();
        if ($template){
            Mail::to($this->assigneTo->email)->send(new CaseAssignMail($this->assigneFrom, $this->case, $this->assigneTo, $template));
        }
    }
}
