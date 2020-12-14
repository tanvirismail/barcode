# Laravel Barcode Generator

### supported barcode format: CODE39, CODE128 

![barcode](https://user-images.githubusercontent.com/32776445/78915992-a0dda580-7aae-11ea-85b6-dedd83a0bd06.png)

```php
use TanvirIsmail\Barcode\Barcode;

$barcode = new Barcode;
$barcode->code('200300001');
$barcode->type('code39');  // code39, code128
$barcode->height(100);
$barcode->barWidth(2);
$barcode->margin(10);
$barcode->background([255, 255, 255]); // transparent = [0, 0, 0, 127]
$barcode->barColor([[0, 0, 0],[255, 255, 255]]);
$barcode->showcode();
$barcode->label('barcode');
$barcode->labelPosition('right'); // center , left, right
```
## response as image
```php
$barcode->responseHeader();
echo $barcode->build();
// for laravel
response($barcode->build())->header('Content-Type', $barcode->getContentType());
```

## view as image
```php
echo '<img src="data:image/png;base64,' . base64_encode($barcode->build()) . '">';
```

## save
```php
$barcode->extension('png');  // jpeg, png
$barcode->path('barcode.png');  // path with file name
$barcode->save();
```

## download
```php
$barcode->download(); 
// if download as file name
$barcode->extension('png'); // default 'png'
$barcode->download('test'); // file name without extention
```
