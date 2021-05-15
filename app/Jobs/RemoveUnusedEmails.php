<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Email;

class RemoveUnusedEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $tz = 'Europe/Madrid';
        // select the emails which:
        // not verified and created_at + 10min > now
        // or
        // verified and verified_at + 10 min > now and id from email not in users ( no user has been created)
        // $emails = Email::
        //     // leftJoin('users', 'emails.id', '=', 'users.email_id')
        //     where(function($query) use ($tz) {
        //         $query
        //             ->where('verified', false)
        //             ->whereRaw(Carbon::create($tz) .'<'. Carbon::create('created_at', $tz)->addMinutes(10));
        //     })
        //     ->orWhere(function($query) use ($tz) {
        //         $query
        //             ->where('verified', true)
        //             ->whereRaw(Carbon::create($tz) .'<'. Carbon::create('verified_at', $tz)->addMinutes(10))
        //             // select emails that is ID is not in users table, 2 ways:
        //             // 1: using left join
        //             // ->where('users.email_id', 'IS NULL');
        //             // 2: using subquery in where clause
        //             ->whereNotIn('id', function($query) {
        //                 $query
        //                     ->select('email_id')
        //                     ->from('users');
        //             });
        //         })
        //     ->get();

        $emails = Email::
            whereNotIn('id', function($query) {
                $query
                    ->select('email_id')
                    ->from('users');
            })
            ->get();
        
        // get the actual date
        $now = Carbon::now();

        foreach ($emails as $email) {
            if ($email->verified) {
                // get the date when the email was verified
                $date = $email->verified_at;
            } else {
                // get the date when the email was created
                $date = $email->created_at;
            }

            // add 10 minutes to the date
            $expiration_date = Carbon::parse($date)->addMinutes(10);

            // check if has passed 10 min from when it was created or verificated
            // add 10 min to the date and compare with the actual date
            if ($expiration_date < $now) {
                // delete from the database leaving the email available
                $email->delete();
            }
        }
    }
}
