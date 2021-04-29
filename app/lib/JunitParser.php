<?php

namespace app\lib;


class JunitParser
{
    public $output;

    public function __construct()
    {
        $xmlFileName = "report.junit.xml";

        $path = realpath(SITE_PATH . "build/logs/$xmlFileName");

        if ($path === false || !file_exists($path)) {
            die("Not found $xmlFileName");
        }

        return $this->run($path);
    }

    public function run($path)
    {
        $xml = simplexml_load_file($path);
        $project = $xml->testsuite;

        ob_start();

        echo '<hr>';

        echo sprintf("total:    %s msec", $this->formatMsec($project['time'])) . '<br>';

        foreach ($project->attributes() as $key => $attribute) {
            echo $key . ': ' . $attribute . '<br>';
        }

        echo '<hr>';

        foreach ($project->testsuite as $testsuite) {
            echo sprintf("  suite:  %s msec : %s", $this->formatMsec($testsuite['time']), $testsuite['name']) . '<br>';

            foreach ($testsuite->attributes() as $key => $attribute) {
                echo '&nbsp;&nbsp;' . $key . ': ' . $attribute . '<br>';
            }

            echo '<hr>';

            if (!empty($testsuite->testsuite)) {
                foreach ($testsuite->testsuite as $testsuite2) {
                    echo '&nbsp;' . sprintf("    suite: %s msec :   %s", $this->printMsec($testsuite2['time']), $testsuite2['name']) . '<br>';

                    foreach ($testsuite2->attributes() as $key => $attribute) {
                        echo '&nbsp;&nbsp;' . $key . ': ' . $attribute . '<br>';
                    }

                    foreach ($testsuite2->testcase as $testcase) {
                        echo '&nbsp;&nbsp;' . sprintf("    case: %s msec :   %s", $this->printMsec($testcase['time']), $testcase['name']) . '<br>';

                        foreach ($testcase->attributes() as $key => $attribute) {
                            echo '&nbsp;&nbsp;&nbsp;' . $key . ': ' . $attribute . '<br>';
                        }
                    }
                }
            } else {
                foreach ($testsuite->testcase as $testcase) {
                    echo '&nbsp;' . sprintf("    case: %s msec :   %s", $this->printMsec($testcase['time']), $testcase['name']) . '<br>';

                    foreach ($testcase->attributes() as $key => $attribute) {
                        echo '&nbsp;&nbsp;' . $key . ': ' . $attribute . '<br>';
                    }
                }
            }

            echo '<hr>';
        }

        $this->output = ob_get_clean();

        return true;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function msec($str)
    {
        return floatval((string)$str) * 1000;
    }

    public function formatMsec($time)
    {
        return sprintf('%9.3f', $this->msec($time));
    }

    public function printMsec($time, $warn = 5, $error = 10)
    {
        $str = $this->formatMsec($time);

        if (!class_exists('ColorCLI')) {
            return $str;
        }

        $msec = $this->msec($time);

        if ($msec < $warn) {
            return ColorCLI::lightGreen($str);
        } elseif ($msec < $error) {
            return ColorCLI::yellow($str);
        }

        return ColorCLI::red($str);
    }
}