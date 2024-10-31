=== Precise Plugin Updater ===
Contributors: cardinal90
Donate link: https://www.paypal.me/Cardinal
Tags: automatic updates, plugins, updates, versions
Requires at least: 3.9.0
Tested up to: 4.9.1
Requires PHP: 5.3
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This automatic plugin updater gives you fine grained control. You may choose to allow any updates, only minor versions, only patch versions, or none.

== Description ==

Have you ever had a plugin update break your site? I have. And it wasn't even a major update. I won't be turning automatic updates for this plugin on in the future. On the other hand, some plugins may be safe to update regardless of version number.

Wordpress plugin developer guidelines recommend using [Semantic Versioning](http://semver.org/). And while not everybody follows it, for many plugins a version number still tells something about possible impact.

With Precise Plugin Updater you choose what type of update is allowed for any single plugin:

* All - allows any updates
* Minor - preserves the first part of a version number
* Patch - preserves the first two parts
* None - turns automatic updates off

This is done on the plugins page itself with a simple interface, that doesn't require page reload.

You may also set a default policy in the settings, and then override it individually.

== Installation ==

1. Download the plugin and unpack it into `/wp-content/plugins/` of your wordpress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Simple interface inregrated into plugins page
2. Easily set the default automatic updates policy.

== Changelog ==

= 1.0.2 =
* Mostly cosmetic code changes to adhere to Wordpress Coding Standards

= 1.0.1 =
* Some minor css for mobile

= 1.0.0 =
* Initial release
