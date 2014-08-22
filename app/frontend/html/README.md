# The HTML Folder

The HTML folder will contain all views used by the site.
The folder structure suggested is similar to the BEM / OOCSS philosophy, with smaller `elements` contained inside
`modules`, used by `templates` within a `layout`.

## HTML Elements Folder

The HTML Elements folder contain the smallest of all html views.

This could be a block of `label` and `input` inside specific `div`s,
a `ul` with multiple `li` items, or any coherent group of html tags that could
be reusable throughout the site but are not big enough to be considered `modules`.

## <a name="modules"></a>HTML Modules Folder

The HTML Modules folder contains partial independent views, to be used freely throughout each
`template` of the site.

For this modules to be independent, they should be self-contained, but should not include any
reference to their positions or their parent containers.

Usually, modules can contain other `modules` and `elements`.

## HTML Templates Folder

The HTML Templates folder should contain views.
This views will be built in a Controller through the `View::make` command, and should contain
the `@extends` reference at the top.

As seen on [HTML modules](#modules), a template is composed out of modules.
This modules are independent of context, and templates `@include` them in the place they
need to, so you could think of templates as the wire frame of each page of your site.

## HTML Layouts Folder

The HTML Layouts folder should contain only views to be used as layouts.
For more information on layouts, read [the blade documentation](http://laravel.com/docs/templates#blade-templating).
