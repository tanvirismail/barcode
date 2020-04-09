<?php
namespace TanvirIsmail\Barcode;

interface BarcodeInterface
{
    public function buildSequence();

    public function mapSequence($char, $pos);

    public function barcode();

    public function code();

    public function calculateCheckDigit();
}