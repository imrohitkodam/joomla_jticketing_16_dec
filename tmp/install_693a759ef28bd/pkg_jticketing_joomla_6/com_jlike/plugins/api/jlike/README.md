# Using the JLike widgets 

JLike allows you to perform various interactions like comments, likes and TODOs for any URL. With the new JLike, APIs are provided that facilitates creation of embeddable javascript widgets. JLike currently bundles widgets for comments, likes and TODOs. This document explains how you can use the embeddable widgets.

JLike supports ebeddable widgets for comments (annotations), likes and TODOs. This allows users to embed a JLike widget anywhere on the page. Each widget needs to be initialised with certain variables. The initialisation returns a JLike content id that will be used to track any actions performed against the content. The widgets need jQuery loaded to function.

## Loading the widget
To initialize a widget, set the `data-jlike-type`, `data-jlike-subtype`, `data-jlike-client` and `data-jlike-url` parameters. The JLike initialisation picks up any html elements that have the `data-jlike-type` attribute and loads the widget inside the element based on the provided configuration.

### data-jlike-type (required)
This defines the type of widget to load. Currently likes, annotations and todos are the supported values. 

### data-jlike-subtype
The subtype is a user defined value that can be used to group interactions. A few examples for subtypes would be allowing multiple comment threads for the same content or allowing multiple like 'buckets' for a content. This parameter is optional.

### data-jlike-client
This specifies which Joomla plugin should be trigerred when a new interaction (comment, like or todo) is saved. This parameter is optional, and if kept empty no plugin will be trigerred.

### data-jlike-url
 This parameter specifies the URL for which the interactions will be tracked. If this parameter is left empty, the current page's URL will be used. JLike creates a unique internal id for each URL.
 
 ### data-jlike-contentid
 Along with the URL, it is also possible to specify the content id. Depending on where a widget is embedded this could be the article id for articles, product id in case of shopping extensions etc.
 
 ### data-jlike-title (required)
 This is the title of the current content piece.
 
### Sample code
The below code will load the everyone comments thread for the current page and trigger the content plugin named myplugin when a new comment is added.

```html
<div id="comments-container" data-jlike-url="<?php echo JURI::current(); ?>" data-jlike-type="annotations" data-jlike-subtype="everyone" data-jlike-client="content.myplugin"></div>
```

The below code will load the collaborator comments thread for the current page and trigger the content plugin named myplugin when a new comment is added.

```html
<div id="comments-container" data-jlike-url="<?php echo JURI::current(); ?>" data-jlike-type="annotations" data-jlike-subtype="collaborator" data-jlike-client="content.myplugin"></div>
```

The below code will load the comments thread that does not have a subtype, and won't trigger any plugin when a new comment is added

```html
<div id="comments-container" data-jlike-url="<?php echo JURI::current(); ?>" data-jlike-type="annotations" data-jlike-subtype="" data-jlike-client=""></div>
```

### Multiple Widgets

It is possible to initialise multiple widgets on the same page


### Programatic Initialisation
It is possible to initialise the comments in a widget by running the following snippet

```javascript
jQuery('#container').jlikeInit({
    type : "",
    subtype : "",
    url : "",
    client : "",
    id : "",
    title : "",
});
```