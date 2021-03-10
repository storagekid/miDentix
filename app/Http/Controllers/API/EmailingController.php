<?php

namespace App\Http\Controllers\API;

use App\Mail\Emailing;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailingController extends Controller
{
    public function sendtest() {
        // dd(request('html'));
        // dd(request('name'));
        $mailTo = 'emailtesting@storagekid.com';
        $mailCC = [];
        // $mailCC[] = 'elena2708@hotmail.com';
        $mailCC = array_merge($mailCC, ['estudiodentix@gmail.com', 'estudiodentix@outlook.com', 'jgvillalba@mozodealmacen.com']);
        // $mailCC[] = 'ialonso@kippleroom.com';
        // $mailCC = ['estudiodentix@gmail.com', 'estudiodentix@outlook.com', 'jgvillalba@mozodealmacen.com', ]; 
        // dump('HERE');
        $backup = Mail::getSwiftMailer();
        // Setup your Mozodealmacen mailer
        $transport = new \Swift_SmtpTransport('smtp.googlemail.com', 465, 'SSL');
        $transport->setUsername('jgvillalba@mozodealmacen.com');
        $transport->setPassword('gyvpzwxhudigkddh');
        $gmail = new \Swift_Mailer($transport);

        Mail::setSwiftMailer($gmail);
        $mail = Mail::to($mailTo)
            ->cc($mailCC)
            ->send(new Emailing('mail-from-api', request('html')));
        return response([
            'model' => $mail
        ], 200);
    }
}
