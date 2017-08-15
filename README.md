# Integrates Facebook Pixel with Craft Commerce

## Overview

This is a plugin that provides default Facebook Pixel functionality for Craft Commerce (CraftCMS). For a full list of events supported visit the [wiki](https://github.com/moment-inc/craft-fbpixel/wiki).

## Getting Started

1. Download and copy to plugins directory.
  * Make sure to name this plugin's folder `fbpixel/`
  * A quick command to do this from the root of your Craft project is `mkdir tmp && curl -L https://github.com/moment-inc/craft-fbpixel/archive/master.zip -o tmp/craft-fbpixel.zip && unzip tmp/craft-fbpixel.zip -d tmp/ && cp -r tmp/craft-fbpixel craft/plugins/fbpixel; rm -rf tmp/;`.
2. Enable the plugin via the admin interface
3. Add a your pixel id in the admin settings
4. Add `{% hook 'fbpixel.renderBase' %}` to your `_layout.twig`
5. Now your template will have all events that don't require additional setup.

Head over to the [wiki](https://github.com/moment-inc/craft-fbpixel/wiki) for a complete list of events and some more deets.

## Contributing

We encourage you to contribute to this plugin! Here are details how to set it up locally for development:

1. Setup a Craft install.
  * I have one local install that I use to develop all Craft plugins
  * Make sure you add Craft Commerce as well
2. Fork this repo
3. Clone the forked repo to your local
  * We would suggest doing this outside of the Craft install
4. Symlink the repo to your Craft install's plugin repo
5. Install in the admin interface

## License

This plugin is released under the [MIT License](http://www.opensource.org/licenses/MIT).
