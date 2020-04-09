# Laravel Barcode Generator

```php
use TanvirIsmail\Barcode\Barcode;

$barcode = new Barcode;
$barcode->code('200300001');
$barcode->type('code39');
$barcode->height(100);
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
$barcode->path('barcode.png');
$barcode->save();
```

## download
```php
$barcode->download(); 
$barcode->download('test'); // if download as file name, then pass file name as a parameter
```
