Provides "on the fly" image resizement using Imagick, CURL & Memcached (by default).

## Installation

### Add AssetOptimizerBundle to your src/Bundle dir

    git submodule add git://github.com/Adenclassifieds/ImageResizerBundle.git src/Bundle/Adenclassifieds/ImageResizerBundle
    
### Add AssetOptimizerBundle to your application Kernel


    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            //..
            new Bundle\Adenclassifieds\ImageResizerBundle\ImageResizerBundle(),
            //..
        );    
    }
    
### Setup file compression in your config.yml

    imageresizer.config: ~

## Usage

just use the configured route in your image src attribute :

the following call will fetch the image from google website, store it in the configured cache manager, resize it using the format "small" defined in your configuration
   
    <img src="/image/resize/small/homothetic?resource=http://www.google.fr/intl/fr_ALL/images/logos/images_logo_lg.gif">

the following call will fetch image from your local filesystem

    <img src="/image/resize/small/homothetic?resource=foo/bar.gif" />
    
you can also use the helper

    <img src="<?php echo $view['imageresizer']->resize('foo/bar', 'homothetic', 'small') ?>" />