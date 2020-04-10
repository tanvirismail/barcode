<?php

namespace TanvirIsmail\Barcode;

class Builder 
{
    
    protected $barWidth = 2;
    protected $barColor = [[0, 0, 0],[255, 255, 255]];
    protected $background = [255, 255, 255]; // transparent = [0, 0, 0, 127]
    protected $margin = 10;
    protected $imageHeight = 100;
    protected $fileExtension = 'png';
    protected $showcode = false;
    protected $label;
    protected $labelPosition = 'center';
    protected $codeInstance;


    public function __construct(
        $codeInstance, 
        $barWidth, 
        $imageHeight, 
        $barColor, 
        $background, 
        $showcode,
        $label,
        $fileExtension,
        $margin,
        $labelPosition
    )
    {
        $this->codeInstance = $codeInstance;
        $this->barWidth = $barWidth; 
        $this->imageHeight = $imageHeight; 
        $this->barColor = $barColor; 
        $this->background = $background; 
        $this->showcode = $showcode;
        $this->label = $label;
        $this->fileExtension = $fileExtension;
        $this->margin = $margin;
        $this->labelPosition = $labelPosition;
    }

    public function make()
    {

        $barsCount = count($this->codeInstance->barcode());
        $padding = $this->barWidth * $this->margin;
        $imageWidth = ($barsCount * $this->barWidth)+($padding*2);
        $image = imagecreatetruecolor($imageWidth, $this->imageHeight);
        imagesavealpha($image, true);

        $color0 = imagecolorallocate($image, $this->barColor[1][0], $this->barColor[1][1], $this->barColor[1][2]);
        $color1 = imagecolorallocate($image, $this->barColor[0][0], $this->barColor[0][1], $this->barColor[0][2] );
        if(count($this->background) == 3){
            $background = imagecolorallocate($image,$this->background[0], $this->background[1], $this->background[2]);
        }
        elseif(count($this->background) == 4){
            $background = imagecolorallocatealpha($image,$this->background[0], $this->background[1], $this->background[2], $this->background[3]);
        }
        imagefill($image,0,0,$background);


        // show code
        if($this->showcode){
            $xcenter = ( imagesx($image) - (strlen($this->codeInstance->code()) * imagefontwidth(5) ) ) /2;
            $y = imagesy($image)-$padding+2;
            imagestring($image, 5, $xcenter, $y, $this->codeInstance->code(), $color1);
        }

        // show label
        if($this->label){
            $x = ( imagesx($image) - (strlen($this->label) * imagefontwidth(5) ) ) /2;
            if($this->labelPosition == 'left'){
                $x = $padding;
            }
            if($this->labelPosition == 'right'){
                $x = ( imagesx($image) - (strlen($this->label) * imagefontwidth(5) ) ) - $padding;
            }
            $y = 2;
            imagestring($image, 5, $x, $y, $this->label, $color1);
        }

        $barHeight = $this->imageHeight-$padding;
        $position = $padding;
        foreach ($this->codeInstance->barcode() as $bit) {
            $color = $bit == 0 ? $color0 : $color1;
            imagefilledrectangle($image, $position , $barHeight, $position+$this->barWidth, $padding, $color);
            $position += $this->barWidth;
        }

        ob_start();
        if($this->fileExtension == 'png'){
            imagepng($image);
        }
        if($this->fileExtension == 'jpeg'){
            imagejpeg($image);
        }
        imagedestroy($image);
        $imagedata = ob_get_clean();
        return $imagedata;
    }

}