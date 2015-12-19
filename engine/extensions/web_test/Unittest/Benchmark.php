<?php
/**
 * Benchmark - a class to test the speed and performance of application
 */

namespace Unittest;


class Benchmark extends \Fructum\Instancer
{
    /**
     * @var array
     */
    private $marks = array();

    /**
     * Benchmark constructor.
     * Puts a label of calculating the execution time for the code
     */
    public function __construct()
    {
        $this->marks[] = microtime(true);
    }

    /**
     * Returns the script execution time
     * @return string
     */
    public function est_time()
    {
        $this->marks[] = microtime(true);
        return number_format($this->marks[1] - $this->marks[0], 4);
    }

    /**
     * Returns the memory usage in kilobytes
     * @return float
     */
    public function get_memory_usage()
    {
        return (memory_get_usage(true) / 1024);
    }
}