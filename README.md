# Handlebars View for CakePHP 1.x

Simple wrapper plugin for XaminProject/handlebars.php

### Installation

```php
class AppController extends Controller {
  public $view = 'Handlebars.Handlebars';
}
```

### Features

#### Drop-In Ready

The view will only render through Handlebars if the template filename 
has one of the supported file extensions:

- `*.hbs`
- `*.handlebars`

They can live happily next to any existing `.ctp` file in your project. You 
can mix and match your template rendering as you see fit or even only 
use Handlebars for elements (recommended).

#### Auto Script Tags

As soon as a view is rendered through Handlebars any template that has been used 
is loaded into the global scripts array and rendered as inline template. It works by 
using the `$scripts_for_layout`, which you should have echo'd in your layout.

```html
<!-- example output -->
<script type="text/x-handlebars-template" id="elements-post">...</script>
<script type="text/x-handlebars-template" id="elements-account">...</script>
<script type="text/x-handlebars-template" id="elements-navigation">...</script>
```

This way you can share them with your Javascript.

### Notes

- Handlebars templates are served and consumed raw, just like the Javascript version.
- This view won't magically transform your CakePHP Helpers to Handlebars Helpers. 
- The focus was on creating and parsing reusable/shareable snippets.
- I probably wouldn't try to write the main layout template in Handlebars. 

### Upgrading

The vendor files are managed by Composer so it should only be a matter of typing:

`composer update`



