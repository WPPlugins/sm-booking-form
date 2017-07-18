=== Booking Form ===
Contributors: Henrik Stacke 
Donate link: 
Tags: Booking
Requires at least: 2.9.1
Tested up to: 3.1.1
Stable tag: 1.3.2

Wordpress Booking plug-in for booking any sort of item. The booking form may be made visible on the public part of your site, or may be used by admin.

== Description ==

The Wordpress Booking Plugin was designed with the intent to allow a Wordpress site owner to offer the booking of *any item* on their website.  
The Plugin may be used to book anything from cars, hotel rooms, equipment, and other services. It's not specific.
If you would like to make any comments, report a bug, or have a look at pre-release versions, then visit http://demo.stackemedia.co.uk.

The plugin contains a form, which may be made available to visitors. Booking plugin users are seperated into two categories "Administrators" and "Gatekeepers". Permissions are based on the Wordpress users email address, and can be assigned by a booking administrator. The installer of the plugin will be assigned as Administrator and Gatekeeper as of version 1.3.

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.   

== Frequently Asked Questions ==

= How do I assign permissions =
Go to "New User" in the booking menu, enter the new users email address and select a level. Add the new user.

= How do I add the booking form to a content page? =
Simply add [smbookingform] to the page (everything in and including the brackets).

== Screenshots ==

1. screenshot.png
  
You may also use the upload plugin function located in the Wordpress dashboard.

== Changelog ==

= 1.2 =
* Initial Version

= 1.3 =
* Added address fields to Items

= 1.3.1 =
* Bug fix: on item details page, the method "sm_booking_getitemdetails" was expecting a parameter, when it shouldn't have. Now fixed.

= 1.3.2 =
* Bug fix: issue with Wordpress memory usage.
* Change: added google maps api key link to the options page, so you know where to get it.
* Change: disable google maps on pages if no google maps api key is provided.

== Upgrade Notice ==

= 1.3.2 =
This version checks if there is a Google API set, if not it will disable Google maps on relevant pages. Also fixed a reported issue where the plugin was eating up Wordpress memory.