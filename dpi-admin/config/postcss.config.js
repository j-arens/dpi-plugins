var postCSSConfig = [
  /* autoprefix for different browser vendors */
  require('autoprefixer'),
  /* enable css @imports like Sass/Less */
  require('postcss-import'),
  /* enable nested css selectors like Sass/Less */
  require('postcss-nested'),
  /* lost grid */
  require('lost'),
  /* require global variables */
  require('postcss-simple-vars')({
    variables: function variables() {
      return require('../src/variables')
    },
    unknown: function unknown(node, name, result) {
      node.warn(result, 'Unknown variable ' + name)
    }
  }),
]

// Export the PostCSS Config for usage in webpack
module.exports = postCSSConfig;
