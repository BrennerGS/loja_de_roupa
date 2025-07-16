<?php

// namespace App\Console\Commands;

// use App\Models\ActivityLog;
// use Illuminate\Console\Command;

// class PruneActivityLogs extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     // protected $signature = 'app:prune-activity-logs';

//     protected $signature = 'activity-logs:prune {--days=90 : Número de dias para manter os logs}';
//     protected $description = 'Remove logs de atividade antigos';


//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Command description';

//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         $days = $this->option('days');
//         $cutoff = now()->subDays($days);

//         $count = ActivityLog::where('created_at', '<', $cutoff)->delete();

//         $this->info("{$count} logs de atividade com mais de {$days} dias foram removidos.");
//         return 0;
//     }
// }
