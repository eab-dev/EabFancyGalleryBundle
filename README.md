EabFancyGalleryBundle
=====================

##Summary

A simple gallery bundle for eZ Publish, using FancyBox.

##Author

Andy Caiger <acaiger@eab.uk>

## Copyright

Copyright (C) 2014-2015 [Enterprise AB Ltd](http://eab.uk)

## License

Licensed under [GNU General Public License 2.0](http://www.gnu.org/licenses/gpl-2.0.html)

## Requirements

* [bower](http://bower.io)
* [fancyBox](https://libraries.io/bower/fancyBox)
* [Bootstrap 3](http://getbootstrap.com/)

## Installation

1.  Install EabFancyGalleryBundle using composer:

        composer require --update-no-dev --prefer-dist eab/fancy-gallery-bundle

    Composer will install the bundle and its dependencies into `vendors`.

    You can use git to install into the `src` subtree:

        git clone https://github.com/eab-dev/EabFancyGalleryBundle.git src/Eab/FancyGalleryBundle

2.  Enable the bundle in the kernel by editing `ezpublish/EzPublishKernel.php`:

    ``` php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Sp\BowerBundle\SpBowerBundle(),
            new Eab\FancyGalleryBundle\EabFancyGalleryBundle(),
            // ...
        );
    }
    ```

3.  Install the latest version of FancyBox:

        php ezpublish/console sp:bower:install
        php ezpublish/console assets:install --symlink

If when installing the bower assets you see an error message like:

    ECMDERR Failed to execute "git ls-remote --tags --heads git://github.com/fancyapps/fancyBox.git", exit code of #128 fatal: unable to connect to github.com

the quick workaround is to disable the `git:` protocol:

    git config --global url."https://".insteadOf git://

and run the install command again.

## Configuration

If your bundle is not extending eZDemoBundle, you need to tell EabFancyGalleryBundle
which pagelayout template to use. There are two easy ways to do this:

1. Edit `ezpublish/config/config.yml`:

        eab_fancy_gallery:
            pagelayout: AcmeMyBundle::pagelayout.html.twig

2. In your own bundle, edit a file such as `src/Acme/MyBundle/Resources/config/services.yml` and add:

        parameters:
            eab_fancy_gallery.pagelayout: AcmeMyBundle::pagelayout.html.twig

   With this second method make sure that your bundle is loaded after EabFancyGalleryBundle.

#Customizing

The following settings can be configured in the same way as `pagelayout`:

* `summary_in_full_view` - whether or not to show the summary
* `page_limit` - number of images to show per page
* `children_types` - array of content types that should be displayed in the gallery
* `image_variation` - the image variation to use for thumbnails

You can also override the templates by copying `Resources/config/override.yaml`
into your own bundle's configuration and changing the controllers or templates
(hint: change the keys e.g. change `image:` to `image_override:`).

The FancyBox CSS is loaded by the gallery template. If you want to load it on
all pages you need to:

1. Override `full/gallery.html.twig` with your own template that doesn't load the CSS.

2. Edit your `page_header_style.html.twig` template and include the FancyBox CSS asset:

        {% stylesheets filter='cssrewrite,?cssmin'
            ...
            'bundles/eabfancygallery/components/fancybox/source/jquery.fancybox.css'
            ...
        %}
        <link rel="stylesheet" type="text/css" href="{{ asset_url }}"/>
        {% endstylesheets %}

#Updating

After installing this bundle you can run `ezpublish/console sp:bower:install`
to update the Fancybox assets at any time. Take care: it will update other
bower assets as well!

## Caveats

1. This bundle assumes your website uses Bootstrap 3. If it doesn't you'll need
to override and modify the templates.
See the [example template for Bootstrap 2](./Resources/doc/bootstrap2-example.md).

2. The configuration for this bundle is not siteaccess aware. If your site has
different layouts for different siteaccesses, you can either override the
gallery and image templates for each of your siteaccesses, or else reprogram
the way that the 'pagelayout' template variable is set. So please fork the
repository, rewrite the code and issue a pull request. Thanks!
