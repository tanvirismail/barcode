<?php

namespace TanvirIsmail\Barcode;

class Barcode 
{
    protected $type;
    protected $code;
    protected $barWidth = 2;
    protected $barColor = [[0, 0, 0],[255, 255, 255]];
    protected $background = [255, 255, 255]; // transparent = [0, 0, 0, 127]
    protected $margin = 10;
    protected $imageHeight = 100;
    protected $path = 'barcode.png';
    protected $fileExtension = 'png';
    protected $showcode = false;
    protected $label;
    protected $labelPosition = 'center';

    public function __construct()
    {
        //
    }

    public function code($code)
    {
        $this->code = $code;
    }

    public function type($type)
    {
        $this->type = $type;
    }

    public function height($imageHeight)
    {
        $this->imageHeight = $imageHeight;
    }

    public function barWidth($barWidth)
    {
        $this->barWidth = $barWidth;
    }

    public function margin($margin)
    {
        $this->margin = $margin;
    }

    public function background($background)
    {
        $this->background = $background;
    }

    public function barColor($barColor)
    {
        $this->barColor = $barColor;
    }

    public function responseHeader()
    {
        header("Content-Type: image/'.$this->fileExtension.'");
        if ( ! headers_sent() ) {
            header_remove();
         }
    }

    public function getContentType()
    {
        return 'image/'.$this->fileExtension;
    }

    public function build()
    {
        if($this->type == 'code39'){
            $code39 = new Code39($this->code);
            
            $barsCount = count($code39->barcode());
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
                $xcenter = ( imagesx($image) - (strlen($this->code) * imagefontwidth(5) ) ) /2;
                $y = imagesy($image)-$padding+2;
                imagestring($image, 5, $xcenter, $y, $this->code, $color1);
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
            foreach ($code39->barcode() as $bit) {
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


        if($this->type == 'code128'){
            $code128 = new Code128($this->code);
            $barsCount = count($code128->barcode());
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
                $xcenter = ( imagesx($image) - (strlen($this->code) * imagefontwidth(5) ) ) /2;
                $y = imagesy($image)-$padding+2;
                imagestring($image, 5, $xcenter, $y, $this->code, $color1);
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
            foreach ($code128->barcode() as $bit) {
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

    public function path($path)
    {
        $this->path = $path;
    }

    public function extension($extension)
    {
        $this->fileExtension = $extension;
    }

    public function save()
    {
        file_put_contents($this->path, $this->build(), FILE_BINARY);
    }

    public function download($name = 'barcode')
    {
        $this->responseHeader();
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Disposition: attachment; filename="'.$name.'.'.$this->fileExtension.'"');
        echo $this->build();
    }

    public function showcode()
    {
        $this->showcode = true;
    }

    public function label($label)
    {
        $this->label = $label;
    }
    
    public function labelPosition($labelPosition)
    {
        $this->labelPosition = $labelPosition;
    }



}
