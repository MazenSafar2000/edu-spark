<?php

namespace App\Console\Commands;

use App\Models\ExamAttempts;
use Illuminate\Console\Command;
use App\Services\ExamFinisher;

class CloseOverdueExamAttempts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exams:close-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ends the exam attempt when the duration ends';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ExamAttempts::where('status', 'in_progress')
            ->where('deadline_at', '<=', now())
            ->chunkById(200, function ($attempts) {
                foreach ($attempts as $attempt) {
                    // استدعِ خدمة إنهاء موحدة (نفس forceFinishAttempt لكن على مستوى الخدمة)
                    app(ExamFinisher::class)->finish($attempt->id);
                }
            });
    }
}
