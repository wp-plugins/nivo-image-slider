=== Nivo Image Slider ===
Contributors: sayful
Tags: slider, image slider, nivo slider, images, wordpress slider, jquery slider, responsive
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress Image slider based on Nivo Slider to display image slider on post, page or theme.

== Description ==

A WordPress Image slider based on [Nivo Slider](http://dev7studios.com/plugins/nivo-slider/) to display image slider on post, page or theme. It's an easy, simple & responsive slider, which looks awesome in every single theme.

Just create your slides from the Slider menu & paste the following shortcode where you want to display this slider:

`[all-nivoslider theme='default|dark|light|bar']`

For example: if you want to add 'light' theme just write as following code

`[all-nivoslider theme='light']`

Or you can paste following to add slider to your theme:

`<?php echo do_shortcode('[all-nivoslider theme='light']'); ?>`

If you want to use multiple slider at diffrent page or post at your theme write the following code

`[nivo-slider][nivoslides image_link=''][/nivo-slider]`

Inside [nivo-slider], you can add id="" to make it unique and you can add theme by adding theme="" and the value of theme that you can use is 'default', 'dark', 'light' or 'bar' as following

`[nivo-slider id='unique-1' theme='default'][/nivo-slider]`
`[nivo-slider id='unique-2' theme='dark'][/nivo-slider]`
`[nivo-slider id='unique-3' theme='light'][/nivo-slider]`
`[nivo-slider id='unique-4' theme='bar'][/nivo-slider]`

Repeat "[nivoslides image_link='']" as many image as you want. Inside image_link='' put you image link like "http://lorempixel.com/400/200/sports/1/"

Inside [nivoslides image_link=''], you can also add 

alt="" to add alternative text,

caption="" to add caption to slide like this

`[nivoslides image_link='' alt='' caption='']`

Here is a complete example of Nivo Slider with ten image and dark theme.

`[nivo-slider id='unique-2' theme='dark'][nivoslides image_link='http://lorempixel.com/400/200/sports/1' caption='This is caption one'][nivoslides image_link='http://lorempixel.com/400/200/sports/2' caption='This is caption two'][nivoslides image_link='http://lorempixel.com/400/200/sports/3' caption='This is caption three'][nivoslides image_link='http://lorempixel.com/400/200/sports/4' caption='This is caption four'][nivoslides image_link='http://lorempixel.com/400/200/sports/5' caption='This is caption five'][nivoslides image_link='http://lorempixel.com/400/200/sports/6' caption='This is caption six'][nivoslides image_link='http://lorempixel.com/400/200/sports/7' caption='This is caption seven'][nivoslides image_link='http://lorempixel.com/400/200/sports/8' caption='This is caption eight'][/nivo-slider]`



<h1>Features</h1>

1. Fully Responsive 
2. Unlimited Slides
3. Supported in all major browsers
4. Beautiful Transition Effects
5. Custom Post and Shortcode system

== Installation ==

Installing the plugins is just like installing other WordPress plugins. If you don't know how to install plugins, please review the two options below:

Install by Search

* From your WordPress dashboard, choose 'Add New' under the 'Plugins' category.
* Search for 'Nivo Image Slider' a plugin will come called 'Nivo Image Slider by Sayful Islam' and Click 'Install Now' and confirm your installation by clicking 'ok'
* The plugin will download and install. Just click 'Activate Plugin' to activate it.

Install by ZIP File

* From your WordPress dashboard, choose 'Add New' under the 'Plugins' category.
* Select 'Upload' from the set of links at the top of the page (the second link)
* From here, browse for the zip file included in your plugin titled 'nivo-image-slider.zip' and click the 'Install Now' button
* Once installation is complete, activate the plugin to enable its features.

Install by FTP

* Find the directory titles 'nivo-image-slider' and upload it and all files within to the plugins directory of your WordPress install (WORDPRESS-DIRECTORY/wp-content/plugins/) [e.g. www.yourdomain.com/wp-content/plugins/]
* From your WordPress dashboard, choose 'Installed Plugins' option under the 'Plugins' category
* Locate the newly added plugin and click on the 'Activate' link to enable its features.


== Frequently Asked Questions ==
Do you have questions or issues with Nivo Images Slider? [Ask for support here.](http://wordpress.org/support/plugin/nivo-image-slider)

== Screenshots ==

1. Screenshot of Nivo Images Slider Shortcode.
2. Screenshot of Nivo Images Slider on post.

== Changelog ==

= version 1.2 =
* A new option has been added to add theme for Slider from custom post type.

= version 1.1 =
* To make the plugin translation ready.
* The plugin is transtated to Bengali Language.

= version 1.0 =
* Implementation of basic functionality.

== CREDIT ==

1.This plugin was developed by [Sayful Islam](http://sayful.net)

== CONTACT ==

[Sayful Islam](http://sayful1.wordpress.com/100-2/)

== Upgrade Notice ==

Upgrade the plugin to get latest feature and faster speed and compatibility with new version.
