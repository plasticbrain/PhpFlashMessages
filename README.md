# PHP Session-Based Flash Messages

Store messages in session data until they are retrieved.  Featuring PSR-4 compliance, Bootstrap compatibility, sticky messages, and more. 

More info at http://mikeeverhart.net/php-flash-messages.

## Notice

This is a new version of https://github.com/plasticbrain/php-flash-messages-legacy. This updated version has been completely rewritten, and therefore **is not compatible with the original version**!

Thank you to everyone that used the old version, and especially to those that left feedback and recommendations!

## Features

* Namespaced
* PSR-4 autoload compliant
* Installable with composer
* Works with Bootstrap
* Fully customizable messages
* Sticky messages



## Roadmap

* Add custom message types
* Persistent messages (show message until it is manually cleared)

## Installation

### With Composer

````shell
composer require plasticbrain/php-flash-messages
````

### Without composer
Download [FlashMessages.php](https://raw.githubusercontent.com/plasticbrain/PhpFlashMessages/master/src/FlashMessages.php) and save it to your project directory.

Import the file:

````php
require '/path/to/FlashMessages.php';
````

## Basic Usage

````php

// Start a Session
if (!session_id()) @session_start();
	
// Instantiate the class
$msg = new \Plasticbrain\FlashMessages\FlashMessages();

// Add messages
$msg->info('This is an info message');
$msg->success('This is a success message');
$msg->warning('This is a warning message');
$msg->error('This is an error message');


// If you need to check for errors (eg: when validating a form) you can:
if ($msg->hasErrors()) {
	// There ARE errors
} else {
  // There are NOT any errors
}
	
// Wherever you want to display the messages simply call:
$msg->display();
````

### Message Types

#### Info
````php
$msg->info('This is a info message');
````
![Info Message](http://mikeeverhart.net/php-flash-messages/assets/img/info.png)

#### Success
````php
$msg->success('This is a success message');
````
![Success Message](http://mikeeverhart.net/php-flash-messages/assets/img/success.png)


#### Warning
````php
$msg->warning('This is a warning message');
````
![Warning Message](http://mikeeverhart.net/php-flash-messages/assets/img/warning.png)

#### Error
````php
$msg->error('This is a error message');
````
![Error Message](http://mikeeverhart.net/php-flash-messages/assets/img/error.png)

#### Message Type Constants
Each message type can be referred to by its constant: INFO, SUCCESS, WARNING, ERROR. For example:
````php
$msg::INFO
$msg::SUCCESS
$msg::WARNING
$msg::ERROR
````

### Redirects

It's possible to redirect to a different URL before displaying a message. For example, redirecting back to a form (and displaying an error message) so a user can correct an error.

The preferred method of doing this is by passing the URL as the 2nd parameter:

````php
$msg->error('This is an error message', 'http://yoursite.com/another-page');
````

A redirect is executed as soon as the message it's attached to is queued. As such, if you need multiple messages AND need to redirect then include the URL with the last message:

````php
$msg->success('This is a success message');
$msg->success('This is another success message');
$msg->error('This is an error message', 'http://redirect-url.com');   
`````

### Sticky Messages
By default, all messages include a close button. The close button can be removed, thus making the message sticky. To make a message sticky pass `true` as the third parameter:

````php
$msg->error("This is a sticky error message (it can't be closed)", null, true);
$msg->warning("This is a sticky warning message (it can't be closed)", null, true);
$msg->success("This is a sticky success message (it can't be closed)", null, true);
$msg->info("This is a sticky info message (it can't be closed)", null, true);
````

![Sticky Info Message](http://mikeeverhart.net/php-flash-messages/assets/img/sticky-info.png)
![Sticky Success Message](http://mikeeverhart.net/php-flash-messages/assets/img/sticky-success.png)
![Sticky Warning Message](http://mikeeverhart.net/php-flash-messages/assets/img/sticky-warning.png)
![Sticky Error Message](http://mikeeverhart.net/php-flash-messages/assets/img/sticky-error.png)

There's also a special method, appropriately enough called `sticky()`, that can be used to make sticky messages:

````php
$msg->sticky('This is also a sticky message');
````

`sticky()` accepts an optional 2nd parameter for the redirect url, and a 3rd for the message type:

````php
$msg->sticky('This is "success" sticky message', 'http://redirect-url.com', $msg::SUCCESS);
```

By default, `sticky()` will render as whatever the default message type is set to (usually `$msg::INFO`.) Use the 3rd parameter override this.

## Helper Methods
### `hasErrors()`

Check to see if there are any queued `ERROR` messages.

````php
if ($msg->hasErrors()) {
    // There are errors, so do something like redirect
}
````

### `hasMessages ( [string $type] )`

Check to see if there are any specific message types (or any messages at all) queued.

````php
// Check if there are any INFO messages
if ($msg->hasMessages($msg::INFO)) {
    ...
}

// Check if there are any SUCCESS messages
if ($msg->hasMessages($msg::SUCCESS)) {
    ...
}

// Check if there are any WARNING messages
if ($msg->hasMessages($msg::WARNING)) {
    ...
}

// Check if there are any ERROR messages
if ($msg->hasMessages($msg::ERROR)) {
    ...
}

// See if there are *any* messages queued at all
if ($msg->hasMessages()) {
    ...
}
````

### `setCloseBtn ( string $html )`

Sets the HTML for the close button that's displayed on (non-sticky) messages.

````php
$msg->setCloseBtn('<button type="button" class="close" 
                        data-dismiss="alert" 
                        aria-label="Close">
                        <span aria-hidden="true">&amp;times;</span>
                    </button>')
````

### `setCssClassMap ( array $cssClassMap )`

Sets the CSS classes that are used for each specific message type.

````php
$msg->setCssClassMap([
    $msg::INFO    => 'alert-info',
    $msg::SUCCESS => 'alert-success',
    $msg::WARNING => 'alert-warning',
    $msg::ERROR   => 'alert-danger',
]);
````

### `setMsgAfter ( string $msgAfter )`

Add a string of text (HTML or otherwise) <b>after</b> the message (but <b>inside</b> of the wrapper.)


For example, wrap a message in `<p>` tags:

````php
$msg->setMsgAfter('</p>')
````

### `setMsgBefore ( string $msgBefore )`

Add a string of text (HTML or otherwise) <b>before</b> the message (but <b>inside</b> of the wrapper.)


For example, wrap a message in `<p>` tags:

````php
$msg->setMsgBefore('<p>')
````

### `setMsgCssClass ( [string $cssClass] )`

Sets the CSS class that is applied to all messages, regardless of their type.

````php
$msg->setMsgCssClass('alert')
````

### `setMsgWrapper ( string $html )`

Sets the HTML that wraps each message. HTML should include two placeholders (`%s`) for the CSS class and message text.

````php
$msg->setMsgWrapper("<div class='%s'>%s</div>")
````

### `setStickyCssClass ( [string $cssClass] )`

Set the CSS class used for sticky messages

````php
$msg->setStickyCssClass('sticky')
````


## License

The MIT License (MIT)

Copyright (c) 2015 Mike Everhart & PlasticBrain Media LLC

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
