module.exports = {
    plugins: [
        require('postcss-import'),
        require('tailwindcss'),
		// require('postcss-simple-vars'),
        require('autoprefixer'),
        require('cssnano')({
            preset: ['default', { 'discardComments': { 'removeAll': true } }]
        }),
    ]
}
