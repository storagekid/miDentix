<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClinicPosterDistribution;
use App\ClinicPosterDistribution;
use App\Clinic;
use App\Mail\PosterDistributionForClinic;
use Illuminate\Support\Facades\Mail;
// use function GuzzleHttp\json_decode;

class ClinicPosterDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = ClinicPosterDistribution::with(['clinic'])->orderBy('clinic_id')->get();
        $grouped = $model->groupBy('clinic_id');

        return response([
            'model' => $grouped,
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinicPosterDistribution $request)
    {
        $clinic = Clinic::withTrashed()->find(request('clinic_id'));
        $address = \App\Address::find(request('address_id'));
        $file = request()->file('file') ? request()->file('file') : request('file');
        // dd(gettype($file));
        $file = ClinicPosterDistribution::storeFile($file, 'facades/' . $clinic->nickname,$address->cleanStreet,true,null,null,true);

        $distribution = ClinicPosterDistribution::make([
            // 'facade' => $file['url'],
            'original_facade_file_id' => $file['id'],
            'address_id' => $address->id,
            'starts_at' => request('starts_at'),
            'distributions' => request('distributions')
        ]);
        $persistedDistribution = $clinic->poster_distributions()->save($distribution);
        $persistedDistribution->files()->save($file);
        
        return response([
            'model' => $persistedDistribution,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClinicPosterDistribution $request, $id)
    {
        $model = ClinicPosterDistribution::find($id);

        $model->update([
            'distributions' => request('distributions'),
            'starts_at' => request('starts_at'),
            'ends_at' => request('ends_at'),
            'address_id' => request('address_id')
            
        ]);

        if (request()->hasFile('file')) {
            \App\File::destroy($model->original_facade_file_id);
            
            $clinic = Clinic::withTrashed()->find(request('clinic_id'));
            $address = \App\Address::find(request('address_id'));
            $file = ClinicPosterDistribution::storeFile(request()->file('file'), 'facades/' . $clinic->nickname, $address->cleanStreet,true,null,null,true);

            $model->update([
                'original_facade_file_id' => $file['id'],
            ]);

            $model->files()->save($file);
        }

        return response([
            'model' => $model,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = ClinicPosterDistribution::find($id);
            ClinicPosterDistribution::destroy($id);
            return response([
                'message' => 'Clinic Poster Distribution ' . $model[$model->getKeyField()] . ' eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
    // public function launch()
    // {
    //     // Backup your default mailer
    //     $backup = Mail::getSwiftMailer();

    //     // Setup your gmail mailer
    //     $transport = new \Swift_SmtpTransport('mail.storagekid.com', 587, null);
    //     $transport->setUsername('jgvillalba@storagekid.com');
    //     $transport->setPassword('Gomez%01');
    //     // Any other mailer configuration stuff needed...

    //     $gmail = new \Swift_Mailer($transport);

    //     // Setup your office365 mailer
    //     $transport = new \Swift_SmtpTransport('smtp.office365.com', 587, 'TLS');
    //     $transport->setUsername('jgvillalba@dentix.es');
    //     $transport->setPassword('Outlook%01');
    //     // Any other mailer configuration stuff needed...

    //     $office365 = new \Swift_Mailer($transport);

    //     // Set the mailer as gmail
    //     // Mail::setSwiftMailer($gmail);

    //     // Set the mailer as office365
    //     Mail::setSwiftMailer($office365);
    //     // dd(request('campaign'));
    //     // Send your message
    //     // Mail::send();
    //     // Mail::to($event->user)->cc(['jgvillalba@dentix.es','estudiodentix@outlook.com'])->send(new PleaseConfirmYourEmail($event->user));
    //     // ->cc(['jgvillalba@dentix.es', 'estudiodentix@outlook.com', 'miriam.gonzalez@dentix.es', 'miriamglezplez@gmail.com', 'bbarragan@dentix.es', 'albacv11@gmail.com', 'mcaliz@dentix.es'])
    //     $clinics = request('clinics');
    //     // dd($clinics[0]);
    //     foreach ($clinics as $clinic) {
    //         $clinic = \App\Clinic::with(['poster_distributions' => function($q) { return $q->with(['address']); }])->find($clinic['id']);
    //         // dd($clinic['poster_distributions'][0]['facade64']);
    //         $mail = Mail::to('jgvillalba@mozodealmacen.com')
    //         // ->cc(['jgvillalba@dentix.es', 'estudiodentix@outlook.com', 'miriam.gonzalez@dentix.es', 'miriamglezplez@gmail.com', 'bbarragan@dentix.es', 'albacv11@gmail.com'])
    //         ->cc(['jgvillalba@dentix.es', 'estudiodentix@outlook.com'])
    //         ->send(new PosterDistributionForClinic(request('campaign'), $clinic));
    //     }

    //     // Restore your original mailer
    //     Mail::setSwiftMailer($backup);
        
    //     return response([
    //         'model' => $mail,
    //     ], 200);
    // }
    public function composeFacade(Request $request, ClinicPosterDistribution $clinicposterdistribution)
    {
        if (!$clinicposterdistribution->composed_facade()->first() || request('force')) {
            $clinicposterdistribution->composeFacadeBuilder();
        }
        if ($request->expectsJson()) {
            return response([
                'model' => $clinicposterdistribution->fresh()->load(['complete_facade', 'composed_facade', 'original_facade']),
                'message' => 'Facade Composed Successfully',
            ], 200);
        }
        return $clinicposterdistribution->composed_facade()->first();
    }

    public function completeFacade(Request $request, ClinicPosterDistribution $clinicposterdistribution)
    {
        $clinicposterdistribution->load(['clinic', 'address']);
        if (!$clinicposterdistribution->composed_facade()->first()) $clinicposterdistribution->composeFacadeBuilder();
        $completeFacde = $clinicposterdistribution->complete_facades()->where('campaign_id', request('campaign'))->first();
        if (!$completeFacde || request('force')) {
            $clinicposterdistribution->completeFacadeBuilder();
        }
        return response([
            'model' => $clinicposterdistribution->fresh()->load(['complete_facade', 'composed_facade', 'original_facade', 'complete_facades']),
            'message' => 'Facade Complete Successfully',
        ], 200);
    }

    public function removeFacade(Request $request, ClinicPosterDistribution $clinicposterdistribution)
    {
        $completeFacade = $clinicposterdistribution->complete_facades()->where('campaign_id', request('campaign'))->first();
        $completeFacade->delete();
        return response([
            'model' => $clinicposterdistribution->fresh()->load(['complete_facade', 'composed_facade', 'original_facade', 'complete_facades']),
            'message' => 'Facade Remove Successfully',
        ], 200);
    }
}
