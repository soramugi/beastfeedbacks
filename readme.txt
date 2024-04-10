=== BeastFeedbacks ===
Contributors:      ytsuyuzaki
Tags:              block, feedback, form
Tested up to:      6.4
Stable tag:        0.1.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Provides a block-editor form for receiving powerful user feedback.

== Description ==

Provides a way to get actionable user feedback on your website.

- Survey Form
- Like button
- Choice voting

These features are visible in the block editor.
The executed content can be checked on the WordPress management screen, and is saved along with the URL, date and time, IP address, etc.
Registration contents can be exported as csv, so you can tally them up as you like.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/beastfeedbacks` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

If you are a developer, you can create a plugin zip file from a git repository.

```
git clone git@github.com:soramugi/beastfeedbacks.git
cd beastfeedbacks
npm install
npm run plugin-zip
```

== Frequently Asked Questions ==

Q1.
I want to update the translation file

A1.
You can help translate WordPress to your language by logging in to the translation platform with your WordPress.org account and suggesting translations (more details).
https://make.wordpress.org/polyglots/handbook/translating/how-to-translate/

Alternatively, you can include the translation files in a git repository.

```
git clone git@github.com:soramugi/beastfeedbacks.git
cd beastfeedbacks
cd languages
cp beastfeedbacks.pot beastfeedbacks-{locale}.po # Describe the translation content
wp i18n make-mo .
wp i18n make-json beastfeedbacks-{locale}.po --no-purge
```

Please commit your artifacts and submit a pull request.
The following documents are available for creating translation files.

https://developer.wordpress.org/cli/commands/i18n/make-mo/
https://developer.wordpress.org/block-editor/how-to-guides/internationalization/


= What does this plugin solve? =

Provide all ways to get user feedback on your project.
For example, by installing a "Like" button, you can visualize how helpful your content is to users.
For example, by setting up a survey, you can check whether the value to your customers is being conveyed correctly.

= Can I download the collected results? =

of course. It is registered in the WordPress database and can be freely downloaded.
It is saved along with the page and date and time on which the survey was conducted, and can be exported in csv format.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 0.1.0 =
* Release

