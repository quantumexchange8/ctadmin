<?php

namespace App\Console\Commands;

use App\Models\TemporaryFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\Filesystem;

class TempImagesDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp_images:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all the temporary uploaded image in database and local folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/uploads');
        TemporaryFile::truncate();
    }
}
