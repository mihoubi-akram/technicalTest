<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class stringReplace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:string_replace {template} {arguments*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'replace string';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $template = $this->argument('template');
        $arguments = $this->argument('arguments');

        foreach ($arguments as $index => $value) {
            $placeholder = '{' . $index . '}';
            $template = str_replace($placeholder, $value, $template);
        }
        
        $this->info($template);
    }
}
