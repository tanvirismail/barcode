<?php

namespace TanvirIsmail\Barcode;

class Code128 implements BarcodeInterface
{

    private $bars = array();
    private $code = null;
    private $code128A = 103;
    private $code128B = 104;
    private $code128C = 105;
    private $stop = 106;
    private $density = 1;

    public function __construct($code)
    {
        $this->code = $code;

        $this->buildSequence();
    }

    public  function buildSequence()
    {
        $checksum = $this->code128A;
        $encoding = array( $this->mapSequence($this->code128A, 0) );
        //Add Code 128 values from ASCII values found in $code
        for ($i = 0; $i < strlen($this->code); $i++) {
            //Add checksum value of character
            $checksum += (ord(substr($this->code, $i, 1)) - 32) * ($i + 1);
            //Add Code 128 values from ASCII values found in $code
            //Position is array is ASCII - 32
            array_push($encoding, $this->mapSequence((ord(substr($this->code, $i, 1))) - 32, 0));
        }

        //Insert the checksum character (remainder of $checksum/103) and STOP value

        array_push($encoding, $this->mapSequence( ($checksum % 103), 0) );
        array_push($encoding, $this->mapSequence( $this->stop, 0) );
        $enc_str = implode($encoding);
        for ($i = 0, $x = 0, $inc = round(($this->density / 72) * 100); $i < strlen($enc_str); $i++) {
            $val = intval(substr($enc_str, $i, 1));
            for ($n = 0; $n < $val; $n++, $x += $inc) {
                if ($i % 2 == 0) {
                    $this->bars[] = 1; 
                } else {
                    $this->bars[] = 0; 
                }
            }
        }
    }

    // public  function buildSequence()
    // {
    //     $checksum = $this->code128B;
    //     $encoding = array( $this->mapSequence($this->code128B, 0) );
    //     //Add Code 128 values from ASCII values found in $code
    //     for ($i = 0; $i < strlen($this->code); $i++) {
    //         //Add checksum value of character
    //         $checksum += (ord(substr($this->code, $i, 1)) - 32) * ($i + 1);
    //         //Add Code 128 values from ASCII values found in $code
    //         //Position is array is ASCII - 32
    //         array_push($encoding, $this->mapSequence((ord(substr($this->code, $i, 1))) - 32, 0));
    //     }

    //     //Insert the checksum character (remainder of $checksum/103) and STOP value

    //     array_push($encoding, $this->mapSequence( ($checksum % 103), 0) );
    //     array_push($encoding, $this->mapSequence( $this->stop, 0) );
    //     $enc_str = implode($encoding);
    //     for ($i = 0, $x = 0, $inc = round(($this->density / 72) * 100); $i < strlen($enc_str); $i++) {
    //         $val = intval(substr($enc_str, $i, 1));
    //         for ($n = 0; $n < $val; $n++, $x += $inc) {
    //             if ($i % 2 == 0) {
    //                 $this->bars[] = 1; 
    //             } else {
    //                 $this->bars[] = 0; 
    //             }
    //         }
    //     }
    // }

    public function barcode()
    {
        return $this->bars;
    }

    public function mapSequence($char, $pos)
    {
        $sequence = array(
            212222, 222122, 222221, 121223, 121322, 131222, 122213, 122312, 132212, 221213,
            221312, 231212, 112232, 122132, 122231, 113222, 123122, 123221, 223211, 221132,
            221231, 213212, 223112, 312131, 311222, 321122, 321221, 312212, 322112, 322211,
            212123, 212321, 232121, 111323, 131123, 131321, 112313, 132113, 132311, 211313,
            231113, 231311, 112133, 112331, 132131, 113123, 113321, 133121, 313121, 211331,
            231131, 213113, 213311, 213131, 311123, 311321, 331121, 312113, 312311, 332111,
            314111, 221411, 431111, 111224, 111422, 121124, 121421, 141122, 141221, 112214,
            112412, 122114, 122411, 142112, 142211, 241211, 221114, 413111, 241112, 134111,
            111242, 121142, 121241, 114212, 124112, 124211, 411212, 421112, 421211, 212141,
            214121, 412121, 111143, 111341, 131141, 114113, 114311, 411113, 411311, 113141,
            114131, 311141, 411131, 211412, 211214, 211232, 23311120
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
