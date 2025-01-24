<php?

protected function schedule(Schedule $schedule)
{
    $schedule->job(new \App\Jobs\SendReminderEmail)->daily();
}
