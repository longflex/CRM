<?php
namespace App\Jobs;

use App\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
class NotifyLeadOfCompletedImport implements ShouldQueue
{
    use Queueable, SerializesModels;

    // public $user;

    // public function __construct(User $user)
    // {
    //     $this->user = $user;
    // }

    public function handle()
    {
        session(['import_message' => 'hello vikash']);
        //Session::flash('import_message',  'This is a message!');
        //Session::flash('alert-class', 'alert-danger');
        //$this->user->notify(new ImportReady());
       //echo "<script>alert('olllllll')</script>";
        //echo 1;die;
    }
}
