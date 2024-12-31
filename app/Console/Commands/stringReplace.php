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

        preg_match_all('/\{(\d+)\}/', $template, $matches);
        $placeholders = $matches[1];
        $indicesMissing = [];

        foreach ($placeholders as $index) {
            if (!array_key_exists($index, $arguments)) {
                $indicesMissing[] = $index;
            } else {
                $placeholder = '{' . $index . '}';
                $template = str_replace($placeholder, $arguments[$index], $template);
            }
        }

        if (!empty($indicesMissing)) {
            $this->warn("Missing arguments for placeholders: {" . implode('}, {', $indicesMissing) . "}");
        } else {
            $this->info($template);
        }
    }
}
