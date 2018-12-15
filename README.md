# Introduction

This is a very simple native PHP template engine based on the ideas as found in 
[Plates](http://platesphp.com/). The templates are mostly compatible with 
Plates templates, so it is easy to switch.

The following features are (not) yet part of Plates, but hopefully are some 
time in the future:

- Themes, this is not working 
  [properly](https://github.com/thephpleague/plates/issues/234) in Plates;
- Internationalization (multi language support)

If you need neither of these features, I recommend you to use Plates.

# Themes

The path to the constructor is an array which can contain multiple folders, the
_first_ folder will be used as the highest priority. If a template (or layout)
is missing from the folder, the next folder will be checked. So put your theme
layout / template overrides in the first folder, and the rest in the "default"
folder.

**NOTE**: most likely the order will change in the near future where the first
folder is the "base" and the next folders can override certain templates, that
seems to make most sense!

# Internationalization

    $tpl = new Template(['/path/to/templates'], '/path/to/locale/nl_NL.php');
    $tpl->render('foo', ['foo' => 'bar']);

In the template you use this:

    <?=$this->t('Hello %foo%!')?>

The translation file, i.e. `nl_NL.php` in this example contains this:

    <?php

    return [
        'Hello %foo%!' => 'Hallo %foo%!'
    ];

# Contact

You can contact me with any questions or issues regarding this project. Drop
me a line at [fkooman@tuxed.net](mailto:fkooman@tuxed.net).

If you want to (responsibly) disclose a security issue you can also use the
PGP key with key ID `9C5EDD645A571EB2` and fingerprint
`6237 BAF1 418A 907D AA98  EAA7 9C5E DD64 5A57 1EB2`.

# License

[MIT](LICENSE).
