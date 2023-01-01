<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Mail\inviteMail;
use App\Jobs\SendInviteJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail($receiver, $name)
    {
        $data = [
            'receiver' => $receiver,
            'name' => $name
        ];
        // SendInviteJob::dispatch($data);
        dispatch(new SendInviteJob($data))->delay(now()->addMinutes(1));
        
    }
}