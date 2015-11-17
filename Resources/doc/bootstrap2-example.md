Bootstrap 2 Example
===================

Example of `gallery/image.html.twig` using Bootstrap 2

```
{% if ez_is_field_empty( content, 'caption' ) %}
    {% set title = ez_field_value( content, 'name' ) %}
{% else %}
    {% set title = ez_field_value( content, 'caption' ).xml.textContent %}
{% endif %}

<div class="content-view-line span2">
    {{ ez_render_field( content,
                        'image',
                        {
                            'template': 'EabFancyGalleryBundle:fields:ezimage_fancybox.html.twig',
                            'parameters': {
                                            'alias': imageVariation,
                                            'title': title,
                                            'class': 'img-responsive'
                                          }
                        } ) }}
</div>
```
