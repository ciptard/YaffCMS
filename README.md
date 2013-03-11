YaffCMS
=======

YaffCMS (yet another flat file CMS) is a crazily small, stupidly fast flat file content management system.

Creating Pages
--------------

Each `.md` file within the 'content' directory is treated as a seperate page. If, for example, your website is located at `http://example.com`, `pages/products.md` can be accessed at `http://example.com/products` and `pages/index.md` can be accessed at `http://example.com`. URLs can be extended by creating subfolders, e.g. `pages/category/product.md` can be accessed at `http://example.com/category/product`.

A list of examples is shown below:

* `pages/index.md` --> `http://example.com`
* `pages/page.md` --> `http://example.com/page`
* `pages/sub/index.md` --> `http://example.com/sub` (same as above)
* `pages/sub/page.md` --> `http://example.com/sub/page`
* `pages/a/stupid/amount.md` --> `http://example.com/a/stupid/amount`

If a file cannot be found, `pages/404.md` is displayed.

Page Markup
-----------

All `.md` files are marked up using [Markdown](http://daringfireball.net/projects/markdown/syntax) and therefore can also contain HTML.

Meta can be applied to each page by adding a block comment at the top of the `.md` file. A 'Page Title' can be added to add the name of the page in the browser's title bar, and 'Page Template' can be used to determine a specific theme file to use. An example of a page's meta is shown below:

```php
<!--
Page Title: This is a title
Page Template: fullwidth
-->
```

These values are added to the `$y` array (detailed below) and can be accessed from within the `.php` and `.md` files.

$y
--

The `$y` variable is an array of values used throughout YaffCMS. These values can be used within any theme file. A selection of available values are shown below:

* `$y['site_title']` - The title of your installation.
* `$y['base_url']` - The URL of your installation.
* `$y['theme']` - The name (slug) of the current theme.
* `$y['theme_url']` - The URL of the current theme.
* `$y['page_title']` - The current page's title.
* `$y['page_template']` - The current page's template.
* `$y['page_content']` - The current page's content.

Custom values can be added in the `settings.php` file in the root directory of your installation.

**All of these values (except for 'page\_content') can be accessed from within any `.md` file; just enclose the name of the value within '&#37;' symbols, e.g. if you would like to access `$y['page_title']`, &#37;page\_title&#37; must be used. This same syntax can be used with any custom values.**

Themes
------

A simple theming system is used to style pages in YaffCMS. The minimum requirements of a theme is to contain just one file, `default.php` (the default page template).

Page templates can be easily added to a theme by creating a new `.php` file. If a new file called `product.php` is added, the 'Page Template' meta value (within a `.md` file) will need to have the value of `product` to be used.