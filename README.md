# Slider

Magento 2 module for creating unlimited sliders with unlimited items.

## Compatibility
Tested with Magento Open Source 2.2.2

For Magento Commerce 2.2.2 version that makes use of [banner functionality](http://docs.magento.com/m2/ee/user_guide/cms/banner-rotator.html) use the [v1 branch](https://github.com/alexryall/magento-slider/tree/v1)

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
"alexryall/slider": "2.0.0"
```
3. From the root of your Magento install run
```
composer update
php bin/magento setup:upgrade
```

## Usage
1. Add the images you want in your slider as slides under Content > Slides
2. Edit the page/block where you want to add a slider
3. Click the "Insert Widget" button in the WYSIWYG editor
4. Choose the widget type "Slider"
5. Choose your speed, direction and fade options
6. Choose the slides you wish to be shown in the slider
7. Click Insert Widget then Save
