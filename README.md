<img src="http://i.imgur.com/AHwuTwa.png">

Bits Editor is your personal playground to develop in HTML, CSS, and Javascript, all from your own server. Bits is written in PHP

* Demo: http://coolbitsbro.com/
* User: demo
* Pass: demo

## Features

* HTML, CSS, and Javascript Editors
* Hotkeys/shortcuts
* Flat File Users
* Share Results
* In Depth Settings for CSS, HTML, Javascript, and additional assets
* Secure CORS Workaround for displaying code
* Framework independent, but still MVC
* Lightweight, ~ 8.5k lines of code
* Extendable

## Requirements
* PHP and MySQL, and an imagination brah, nothing crazy

## Install

There are a few things you must do before you can get started playing with Bits Editor, but don't worry, they're really small.

### 1. Install the single table that Bits uses

Bits uses a single table in it's database. The `.sql` file to install is located in `/setup/isntall.sql`

### 2. Editor your Config File

Bits has a lot of settings for you to mess with. Navigate to `/www/app/config/config.php` to access them. You are required to set your `base_url`, your `code_url` (more no this option below), all of the prefixed `db_` properties, and lastly, your `users`.

The `code_url` is the same url as your application, but it has a subdomain pointing to the main install. This is to thwart your code iframes from having access to the editor itself.

## Go!

Bits will be ready for you to play with at this point. Have fun!


<hr />

# config.php Options

* `autoload` - This is an array of plugins and helpers to autoload into bits everytime a request is sent.
* `reserved_translate` - Bits uses MVC with **no textual routing**, meaning your filenames must match the URI. Because `new` is a reserved keyword in PHP, we must use this array to define what the `new` keyword will point to. By default, this is set to `reserved_new`
* `base_bit_settings` - These are the default settings for Bits HTML, CSS, and Javascript
* `base_editor_settings` - These are the default settings for your Bits Editors, including theme, tab size, line wrapping, and more.
* `libraries` - This is an array of arrays used to dynamically list what libraries you want to have available to your users when writing their code.

## Screenshots

<img src="http://i.imgur.com/qlCNc4z.jpg"><hr />
<img src="http://i.imgur.com/SrYrutQ.jpg"><hr />
<img src="http://i.imgur.com/qcU6tFj.jpg"><hr />
<img src="http://i.imgur.com/PRCfvL9.jpg"><hr />
<img src="http://i.imgur.com/795zUgW.jpg"><hr />
<img src="http://i.imgur.com/X8lBIGf.jpg">

