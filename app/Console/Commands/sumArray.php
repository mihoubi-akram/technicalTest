<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;

class sumArray extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:array_sum {array}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calculate the sum of array';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $arrayInput = $this->argument('array');
        $array = json_decode($arrayInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Error : Invalid JSON input');
            return 1;
        }

        if (!is_array($array)) {
            $this->error('Error : format invalide format');
            return 1;
        }

        $sum = $this->calculateSum($array);
        $this->info("$sum");

        return 0;
    }


    private function calculateSum(array $array): int
    {
        $sum = 0;

        foreach ($array as $item) {
            if (is_array($item)) {
                $sum += $this->calculateSum($item);
            } else {
                $sum += $item;
            }
        }

        return $sum;
    }
}
