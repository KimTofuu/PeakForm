<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MealReminder;

class SendMealReminders extends Command
{
    protected $signature = 'meal:remind';

    protected $description = 'Send meal reminder emails to users';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new MealReminder($user));
        }

        $this->info('Meal reminders sent!');
    }
}
