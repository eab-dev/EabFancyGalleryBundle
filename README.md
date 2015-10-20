EabFancyGalleryBundle
=====================

##Summary

A simple gallery bundle for eZ Publish, using FancyBox.

##Author

Andy Caiger <acaiger@eab.uk>

##Copyright

Copyright (C) 2014-2015 [Enterprise AB Ltd](http://eab.uk)

##License

Licensed under [GNU General Public License 2.0](http://www.gnu.org/licenses/gpl-2.0.html)

##Requirements

* [bower](http://bower.io)
* [fancyBox](https://libraries.io/bower/fancyBox)
* [Bootstrap 3](http://getbootstrap.com/)

##Installation

Add EabFancyGalleryBundle to your `composer.json` and download it by running:

    $ php composer.phar require eab/fancygallerybundle

Composer will install the bundle and its dependencies and use bower to install
the latest version of FancyBox.

Enable the bundle in the kernel by editing `ezpublish/EzPublishKernel.php`:

``` php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Sp\BowerBundle\SpBowerBundle(),
        new Eab\FancyGalleryBundle\EabFancyGalleryBundle(),
    );
}
```

Unless you want to create your own style for the popups, edit
your `page_header_style.html.twig` template and include the FancyBox CSS asset:

    {% stylesheets filter='cssrewrite,?cssmin'
        ...
        'bundles/eabfancygallery/components/fancybox/source/jquery.fancybox.css'
        ...
    %}
    <link rel="stylesheet" type="text/css" href="{{ asset_url }}"/>
    {% endstylesheets %}

If you didn't use Composer to install the bundle, install the latest version of
FancyBox manually:

    php ezpublish/console sp:bower:install
    php ezpublish/console assets:install --symlink

If your bundle is not extending eZDemoBundle, you need to tell EabFancyGalleryBundle
which pagelayout template to use. There are two easy ways to do this:

1. Edit `ezpublish/config/config.yml`:

        eab_fancy_gallery:
            pagelayout: AcmeMyBundle::pagelayout.html.twig

2. In your own bundle, edit a file such as `src/Acme/MyBundle/Resources/config/services.yml` and add:

        parameters:
            eab_fancy_gallery.pagelayout: AcmeMyBundle::pagelayout.html.twig

#Customizing

The following settings can be configured in the same way as `pagelayout`:

* `summary_in_full_view` - whether or not to show the summary
* `page_limit` - number of images to show per page
* `children_types` - array of content types that should be displayed in the gallery
* `image_variation` - the image variation to use for thumbnails

You can also override the templates by copying `Resources/config/override.yaml`
into your own bundle's configuration and changing the controllers or templates
(hint: change the keys e.g. change `image:` to `image_override:`).

#Updating

After installing this bundle you can run `ezpublish/console sp:bower:install`
to update the Fancybox assets at any time. Take care: it will update other
bower assets as well!

## Caveats

1. This bundle assumes your website uses Bootstrap 3. If it doesn't you'll need
to override and modify the templates.

2. The configuration for this bundle is not siteaccess aware. If your site has
different layouts for different siteaccesses, please fork the repository,
rewrite the code and issue a pull request. Thanks!
