<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use App\Stationary;
use App\Clinic;
use App\Profile;

class StationaryOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $stationaries;
    public $clinic;
    public $user;
    public $profile;
    public $buttons = [];
    public $files = [];
    public $attach = true;
    public $withLinks = false;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($stationaries)
    {
        $this->stationaries = $stationaries;
        $this->clinic = $stationaries[0]->clinic;
        $this->user = $stationaries[0]->user;

        if ($this->withLinks) {
            foreach ($this->stationaries as $order) {
                if ($order->orderable->name == 'medicalChart') {
                    $this->buttons['medicalCharts'][] = $order->profile_id;
                } elseif ($order->orderable->name == 'medicalChartJob') {
                    $this->buttons['medicalChartJob'][] = $order->details;
                } elseif ($order->orderable->name == 'businessCard') {
                    $this->buttons['businessCards'][] = $order->profile_id;
                } else {
                    $this->buttons['stationaries'][] = $order->orderable_id;
                }
            }
        }
        
        if ($this->attach) {
            $stationariesIds = [];
            $profilesIds = [];
            $jobsIds = [];
            $cardIds = [];

            foreach ($this->stationaries as $order) {
                if ($order->orderable->name == 'medicalChart') {
                    $profilesIds[] = $order->profile_id;
                } elseif ($order->orderable->name == 'medicalChartJob') {
                    $jobsIds[] = $order->details;
                } elseif ($order->orderable->name == 'businessCard') {
                    $cardIds[] = $order->profile_id;
                } else {
                    $stationariesIds[] = $order->orderable_id;
                }
            }
            if (count($profilesIds)) {
                // $profiles = \App\Profile::find($profilesIds);
                $profiles = [];
                foreach ($profilesIds as $id) {
                    $profiles[] = \App\Profile::find($id);
                }
                $this->files['medicalCharts'] = \App\Profile::makeCharts($profiles, $this->clinic);
            }
            if (count($cardIds)) {
                $profiles = \App\Profile::find($cardIds);
                foreach ($profiles as $profile) {
                    $this->files['businessCards'][] = \App\Profile::makeBusinessCard($profile, $this->clinic);
                }
            }
            if (count($jobsIds)) {
                $jobTypes = \App\JobType::whereIn('name',$jobsIds)->get();
                foreach ($jobTypes as $job) {
                    if (!Storage::exists('job-charts/' . $job->name . '.pdf')) {
                        \App\Profile::makeJobCharts($job);
                    }
                    $file = storage_path('app/job-charts/' . $job->name . '.pdf');
                    $this->files['medicalChartJobs'][] = $file;
                }
            }
            if (count($stationariesIds)) {
                $stationariesFetched = \App\Stationary::find($stationariesIds);
                foreach ($stationariesFetched as $stationary) {
                    if ($stationary->customizable) {
                        $temp = \App\ClinicStationary::where(['stationary_id' => $stationary->id, 'clinic_id' => $this->clinic->id])->pluck('link')->toArray();
                        $this->files['stationaries'][] = storage_path('app/'.$temp[0]);
                        // dd($temp[0]);
                    }
                    else {
                        $temp = \App\Stationary::where(['id'=>$stationary->id])->pluck('link')->toArray();
                        if ($temp[0]) {
                            $this->files['stationaries'][] = storage_path('app/'.$temp[0]);
                        }
                    }
                }
            }
        }
        // dd($this->buttons);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('emails.stationaryOrder')
                        ->from($this->user->email)
                        ->subject('Pedido para ' . $this->clinic->fullName);
        if (array_key_exists('medicalCharts', $this->files)) {
            $mail->attach(storage_path($this->files['medicalCharts']));
        }
        if (array_key_exists('medicalChartJobs', $this->files)) {
            foreach ($this->files['medicalChartJobs'] as $file) {
                $mail->attach($file);
            }
        }
        if (array_key_exists('businessCards', $this->files)) {
            foreach ($this->files['businessCards'] as $file) {
                $mail->attach($file);
            }
        }
        if (array_key_exists('stationaries', $this->files)) {
            foreach ($this->files['stationaries'] as $file) {
                $mail->attach($file);
            }
        }
        // if ($this->chartsFile2) {
        //     $mail->attach(storage_path($this->chartsFile2));
        //     Storage::delete($this->chartsFile);
        // }
        // dd($this->buttons);
        return $mail;
        // return $this->markdown('emails.stationaryOrder')
        //             ->from($this->user->email)
        //             ->subject('Pedido para ' . $this->clinic->fullName)
        //             ->attach($this->chartsFile);
    }
}
