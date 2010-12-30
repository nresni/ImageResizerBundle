Provides "on the fly" image resizement using Imagick, CURL & Memcached (by default).

## Installation

### checkout the bundle to your src/Bundle dir

    git submodule add git://github.com/Adenclassifieds/ImageResizerBundle.git src/Bundle/Adenclassifieds/ImageResizerBundle

### Initalize the bundle into your application Kernel


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
        # the cache adapter
        cache: 
          class: memcache # accepted are : memcache, mongo
          dsn: localhost
          port: 11211
          # for mongo only
          database: imageresizer
          collection: files

        # available functions (activated by default)
        functions : [cropCenter, adaptive, homothetic]
        
        # named sizes
        sizes:
            small: [32, 32] # width, height (default)
            
        # where to find the images (default to /tmp)
        base_directory: /path/to/images

### For Mongodb based cache only :

please run the following command to create the database and collection with correct indexes

    ./console imageresizer:initialize:mongo

## Usage

just use the configured route in your image src attribute :

the following call will fetch the image from google website, store it in the configured cache manager, resize it using the format "small" defined in your configuration
   
    <img src="/image/resize/small/homothetic?resource=http://www.google.fr/intl/fr_ALL/images/logos/images_logo_lg.gif">

the following call will fetch image from your local filesystem

    <img src="/image/resize/small/homothetic?resource=foo/bar.gif" />
    
you can also use the helper

    <img src="<?php echo $view['imageresizer']->url('foo/bar.gif', 'homothetic', 'small') ?>" />
    
or, if you are attentive to client side performance, use the image method that provides width and height attributes

    <?php $view['imageresizer']->image('foo/bar.gif', 'homothetic', 'small', array('class' => 'test')) ?> // output <img src="/image/resize/small/homothetic?resource=foo/bar.gif" class="test" height="64" width="32"/>

    