<?php

namespace TanvirIsmail\Barcode;

class Barcode 
{
    protected $type = 'code39';  // default
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
            $format = new Code39($this->code);
        }
        if($this->type == 'code128'){
            $format = new Code128($this->code);
        }
        $bulid = new Builder(
            $format, 
            $this->barWidth, 
            $this->imageHeight, 
            $this->barColor, 
            $this->background, 
            $this->showcode,
            $this->label,
            $this->fileExtension,
            $this->margin,
            $this->labelPosition
        );
        return $bulid->make();
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
