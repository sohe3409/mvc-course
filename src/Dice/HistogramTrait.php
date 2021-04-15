<?php

namespace sohe\Dice;

/**
 * A trait implementing histogram for integers.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    public $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }

    public function setHistogramSerie($serie)
    {
        $this->serie = $serie;
    }


    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram()
    {
        $histogramArray = array();
        foreach ($this->serie as $v) {
            $k = (int)$v;
            if (!array_key_exists($k, $histogramArray)) {
                $histogramArray[$k] = 0;
            }
            $histogramArray[$k]++;
        }
        $res = "";
        ksort($histogramArray);
        foreach ($histogramArray as $key => $value) {
            $res .= $key . ": " . str_repeat("*", $value) . "<br>";
        }
        return $res;
    }
}
