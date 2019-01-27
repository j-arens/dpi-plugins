# MyParish App Plugin - Work In Progress

Improvements over last version:

 * Componentized architecture - easily extend and implement new client facing components.
 * App messages sync with the server and delete themselves.
 * Customize component colors from the plugin page
 * Exposed global function can be called to get an array of the messages outside of the plugin


Shortcode:

```
[dpi_mpa_messages]
```

Get an array of app messages outside of the plugin:

```php
$quantity = 5;
$messages = MyParishApp\Plugin\getMpaMessages($quantity);
```

Styles are written in PostCSS and JS is written in ES6. Use the following steps to compile down.

1. Make sure the node.js runtime is installed on your computer.
2. Open a command prompt

```bash
cd ../path-to-folder
npm i #install dev dependencies, this will take a minute

#available commands
npm run build #compile
npm run build-watch #compile each time a .css or js file in its source folder changes
```
