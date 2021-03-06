<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mail;

class EnviarEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siscomp:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia correos para los distintos eventos del sistema de compensatorios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

       global $data;
        $emails = DB::table('email')
                         ->select('*')
                         ->where('status','=',0)
                         ->get();


       foreach ($emails as $email) {
            $data = [
                'name'      => 'Saludos',
                'mensaje'   => $email->message,
                'subject'   => $email->subject,
                'to'        => $email->to,
                'cc'        => $email->cc,
                'id'        => $email->id

            ];


            Mail::send('emails.contact', $data, function($msj){
                global $data;
                $to = explode(",", $data['to']);
                $cc = explode(",", $data['cc']);
                $msj->subject($data['subject']);
                $msj->to($to);
                $msj->cc($cc);
            });

            DB::table('email')
                ->where('id', '=', $data['id'])
                ->update(['status' => 1]);
        }
        
        //$this->info('Paso!');

    }
}
