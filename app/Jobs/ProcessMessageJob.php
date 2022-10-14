<?php

namespace App\Jobs;

use App\Models\Job;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The thread id
     *
     * @var string
     */
    public $threadId = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $threadId)
    {
        $jobs = Job::all();
        $threadActive = false;
        if (count($jobs) > 0) {
            foreach ($jobs as $job) {
                $command = $job->payload['data']['command'];
                $commandUnserialized = unserialize($command);
                $jobThreadId = $commandUnserialized->threadId;

                if ($threadId == $jobThreadId) {
                    $threadActive = true;
                }
            }
        }

        if (! $threadActive) {
            $this->threadId = $threadId;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $messages = Message::getMessagesByThreadIdAndOneMinuteAgo($this->threadId);
        $numMessages = count($messages);
        $userEmails = [];
        foreach ($messages as $message) {
            $email = $message->user->email;
            if (! in_array($email, $userEmails)) {
                $userEmails[] = $email;
            }
        }

        foreach ($userEmails as $userEmail) {
            error_log('Hey '.$userEmail.' - there are '.$numMessages.' new messages in Thread '.$this->threadId);
        }
    }
}
