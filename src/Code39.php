<?php
namespace TanvirIsmail\Barcode;

class Code39 implements BarcodeInterface
{

    private $bars = array();
    private $code = null;

    public function __construct($code)
    {
        $this->code = strtoupper($code);

        $this->buildSequence();
    }

    public function buildSequence()
    {
        $code = "*" . $this->code . "*";

        for ($i = 0; $i < strlen($code); $i++) {
            $this->bars = array_merge($this->bars, $this->mapSequence($code[$i], $i));
            $this->bars[] = 0;
        }
    }

    public function barcode()
    {
        return $this->bars;
    }

    public function mapSequence($char, $pos)
    {
        $sequence = array(
            "0" => array(1, 0, 1, 0, 0, 1, 1, 0, 1, 1, 0, 1),
            "1" => array(1, 1, 0, 1, 0, 0, 1, 0, 1, 0, 1, 1),
            "2" => array(1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1),
            "3" => array(1, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 1),
            "4" => array(1, 0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 1),
            "5" => array(1, 1, 0, 1, 0, 0, 1, 1, 0, 1, 0, 1),
            "6" => array(1, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 1),
            "7" => array(1, 0, 1, 0, 0, 1, 0, 1, 1, 0, 1, 1),
            "8" => array(1, 1, 0, 1, 0, 0, 1, 0, 1, 1, 0, 1),
            "9" => array(1, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 1),
            "A" => array(1, 1, 0, 1, 0, 1, 0, 0, 1, 0, 1, 1),
            "B" => array(1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1, 1),
            "C" => array(1, 1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1),
            "D" => array(1, 0, 1, 0, 1, 1, 0, 0, 1, 0, 1, 1),
            "E" => array(1, 1, 0, 1, 0, 1, 1, 0, 0, 1, 0, 1),
            "F" => array(1, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1),
            "G" => array(1, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1),
            "H" => array(1, 1, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1),
            "I" => array(1, 0, 1, 1, 0, 1, 0, 0, 1, 1, 0, 1),
            "J" => array(1, 0, 1, 0, 1, 1, 0, 0, 1, 1, 0, 1),
            "K" => array(1, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1, 1),
            "L" => array(1, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 1),
            "M" => array(1, 1, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1),
            "N" => array(1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1, 1),
            "O" => array(1, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1),
            "P" => array(1, 0, 1, 1, 0, 1, 1, 0, 1, 0, 0, 1),
            "Q" => array(1, 0, 1, 0, 1, 0, 1, 1, 0, 0, 1, 1),
            "R" => array(1, 1, 0, 1, 0, 1, 0, 1, 1, 0, 0, 1),
            "S" => array(1, 0, 1, 1, 0, 1, 0, 1, 1, 0, 0, 1),
            "T" => array(1, 0, 1, 0, 1, 1, 0, 1, 1, 0, 0, 1),
            "U" => array(1, 1, 0, 0, 1, 0, 1, 0, 1, 0, 1, 1),
            "V" => array(1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 1),
            "W" => array(1, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1),
            "X" => array(1, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1, 1),
            "Y" => array(1, 1, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1),
            "Z" => array(1, 0, 0, 1, 1, 0, 1, 1, 0, 1, 0, 1),
            "-" => array(1, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 1),
            "." => array(1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1),
            " " => array(1, 0, 0, 1, 1, 0, 1, 0, 1, 1, 0, 1),
            "$" => array(1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
            "/" => array(1, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 1),
            "+" => array(1, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1),
            "%" => array(1, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1),
            "*" => array(1, 0, 0, 1, 0, 1, 1, 0, 1, 1, 0, 1),
        );

        return $sequence[$char];
    }

    public function calculateCheckDigit()
    {
        return 0;
    }

    public function code()
    {
        return $this->code;
    }
}