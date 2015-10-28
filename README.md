PHP Session-Based Flash Messages
================================

Stores messages in session data to be easily retrieved later on. This class includes four different types of messages:

* Success
* Error
* Warning
* Information


What's New
----------
This is a new version of https://github.com/plasticbrain/php-flash-messages-legacy. This updated version has been completely rewritten, and therefore **is not compatible with the original version**!

* Namespaced
* PSR4 autoload compliant
* Installable with composer
* Updated to work with Bootstrap
* Methods are now chainable 

Thank you to everyone that used the old version of this, and especially to those
that left feedback and recommendations!


Basic Usage
-----------

````php

// Start a Session
if (!session_id()) @session_start();
	
// Include the file
// Note: this is not required if using composer or other autoloading (recommended)
require_once 'PhpFlashMessages/src/FlashMessages.php';

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
	
// Where ever you want to display the messages simply call:
$msg->display();
````

Redirects
---------
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

Sticky Messages
---------------
By default, all messages include a close button. The close button can be removed, thus making the message sticky. To make a message sticky pass true as the third parameter:

````php
$msg->error("This is a sticky error message (it can't be closed)", null, true);
$msg->warning("This is a sticky warning message (it can't be closed)", null, true);
$msg->success("This is a sticky success message (it can't be closed)", null, true);
$msg->info("This is a sticky info message (it can't be closed)", null, true);
````

There's also a special method, appropriately enough called `sticky()`, that can be used to make sticky messages:

````php
$msg->sticky('This is also a sticky message');
````

`sticky()` accepts an optional 2nd parameter for the redirect url, and a 3rd for the message type:

````php
$msg->sticky('This is "success" sticky message', 'http://redirect-url.com', $msg::SUCCESS);
```

By default, `sticky()` will render as whatever the default message type is set to (usually info.) Use the 3rd parameter override this.


Roadmap
-------
* Add custom message types



License
-------

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
