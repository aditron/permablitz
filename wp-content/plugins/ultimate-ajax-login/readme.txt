=== Ultimate AJAX Login ===
Contributors: arbet01
Tags: admin, AJAX, AJAX login, login, multi-site, redirect, registration, sidebar, jquery, popup, dialog, login dialog, login popup, mobile
Requires at least: 3.1
Tested up to: 4.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Very flexible and easy to use AJAX Login plugin with redirects, customizable templates...

== Description ==

After testing all of the AJAX plugins in the Wordpress repository, I got frustrated. They're all great, but it seems that they're like 90% complete. They still need polishing.  This is why I decided to create this plugin

How is this plugin different:

*   Three different templates to choose from: Modal login form, Classic login form and popup login form (jQuery UI based)
*   24 themes to choose from (jQuery UI based)  
*   Fully customizable: Just copy the template you're using from /templates/ directory in the plugin to the "ultimate_ajax_login" directory in your theme, and modify as you need to.
*   After a user is logged in, nothing shows up. I found this pretty frustrating with other plugins, there was no way to hide things.
*   If you need to show anything after a user logs in, just copy the template widget-logged-in.php to your ultimate_ajax_login folder and add whatever you need. You can call any WP function from there.
*   Has three templates, one an AJAX-based classic login form, and the other is a jQuery UI dialog box (Tested and works on mobile), and the third one is a popmodal dialog box
* Blocks the login form whenever a user is being logged in.
*   Allows you to specify a global login redirect URL in your settings page, which applies to all of your widgets.
* Login redirect URL can be overridden on a per-widget basis from the widget options page.

    
*Shortcode Usage*

Instead of using the widget, you can insert the shortcode inside any post. If you're a theme developer, you can use it with the do_shortcode() function. Here are the varius option

* Using with classic template and no redirect url specified: _[ultimate_ajax_login]_ 
* Using the dialog box template: _[ultimate_ajax_login template='dialog']_
* Using the dialog box template and a jquery theme: _[ultimate_ajax_login template='dialog' theme='cupertino']_

== Installation ==

1. Install the plugin as usual
1. Go to Settings -> Ultimate AJAX Login and customize like you wish
1. Go to Appearance -> Widgets, add your widget and select the template you want to use

== Frequently Asked Questions ==

= My widget does not show up =

Make sure you are logged out of the site. It will not display anything by default. You can always display a message for logged in users by copying the widget-logged-in.php file from */ultimate-ajax-login/templates* to a directory called *ultimate_ajax_login* in your active theme. Create the directory if it does not exist

= How do I change the jQuery UI styling in dialog box? =

Just copy the template widget-dialog.php to ultimate_ajax_login/widget-dialog.php in your active theme directory , and change the CSS link on the top of the file to point to the style you want

== Screenshots ==

1. Widget as it shows under Appearance -> Widgets
2. Classic Widget in footer sidebar
3. Dialog Widget after user clicks login button
4. Modal login form on Twenty Fourteen theme

== Changelog ==

= 1.2 = 
* Added settings to allow further customizations of plugin (Custom error message, Custom text in login form...)

= 1.1 = 
* Added a new modal layout

= 1.0.1 =
* Initial push to wordpress repository