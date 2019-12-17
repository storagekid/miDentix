<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Mail;
// use Illuminate\Support\Facades\Mail;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Mail\ExceptionOccured;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        PosterDistributionException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendEmail($exception); // sends an email
        }

        return parent::report($exception);
    }

    /**
     * Sends an email to the developer about the exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function sendEmail(Exception $exception)
    {
        try {
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = $handler->getHtml($e);

            // Backup your default mailer
            $backup = Mail::getSwiftMailer();
            // Setup your office365 mailer
            $transport = new \Swift_SmtpTransport('smtp.office365.com', 587, 'TLS');
            $transport->setUsername('jgvillalba@dentix.es');
            $transport->setPassword('Dentix%30');
            // Any other mailer configuration stuff needed...
            $office365 = new \Swift_Mailer($transport);
            // Set the mailer as office365
            Mail::setSwiftMailer($office365);

            Mail::to('jgvillalba@dentix.es')->send(new ExceptionOccured($html));

            // Restore your original mailer
            Mail::setSwiftMailer($backup);

        } catch (Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                "message" => $exception->getMessage()
            ], 400);
        }
        if ($exception instanceOf \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('login')->with('status','Sorry, your session seems to have expired. Please try again.');
        }
        return parent::render($request, $exception);
    }
}
