# Slider

Magento 2 module for creating unlimited sliders with unlimited items.

## Installation
1. In composer.json inside repositories add:
```
{
    "type": "git",
    "url": "git@github.com:alexryall/magento-slider.git"
}
```
2. In composer.json inside require add:
```
"alexryall/slider": "1.0.0"
```
3. From the root of your Magento install run
```
composer update
php bin/magento setup:upgrade
```

## Usage
1. Add the images you want in your slider as banners under Content > Banners, ensuring you use the "Insert Image..." option under the Content section each time
2. Edit the page/block where you want to add a slider
3. Click the "Insert Widget" button in the WYSIWYG editor
4. Choose the widget type "Slider"
5. Choose your speed, direction and fade options
6. Search for banners and choose the banners you wish to be shown in the slider
7. Click Insert Widget then Save
