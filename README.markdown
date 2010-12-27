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

    imageresizer.config:
   
   
## Usage

in your template :
   
    <img src="/image/resize/32/homotheticResize?resource=http://www.google.fr/intl/fr_ALL/images/logos/images_logo_lg.gif">