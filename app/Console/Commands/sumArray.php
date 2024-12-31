<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $array = $this->getArrayFromInput($this->argument('array'));

        if ($array === null) {
            $this->error('Error : Invalid JSON input');
            return 1;
        }

        if (!is_array($array)) {
            $this->error('Error : Invalid format');
            return 1;
        }

        if (!$this->validateArray($array)) {
            $this->error('Error : Elements of array must be numbers');
            return 1;
        }

        $sum = $this->calculateSum($array);
        $this->info("The sum of the array elements is: $sum");

        return 0;
    }

    private function getArrayFromInput(string $input): ?array
    {
        $array = json_decode($input, true);
        return json_last_error() === JSON_ERROR_NONE ? $array : null;
    }

    private function validateArray(array $array): bool
    {
        foreach ($array as $item) {
            if (is_array($item)) {
                if (!$this->validateArray($item)) {
                    return false;
                }
            } elseif (!is_numeric($item)) {
                return false;
            }
        }
        return true;
    }

    private function calculateSum(array $array): int
    {
        $sum = 0;
        foreach ($array as $item) {
            $sum += is_array($item) ? $this->calculateSum($item) : $item;
        }
        return $sum;
    }
}
