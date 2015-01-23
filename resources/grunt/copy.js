module.exports = {
	development: {
		files: [
			{
				flatten: true,
				expand: true,
				src: './bower_components/less.js/dist/less-1.7.4.min.js',
				dest: './public/assets/js/',
				rename: function(dest){
					return dest + 'less.js';
				}
			},
			{
				flatten: true,
				expand: true,
				src: './bower_components/requirejs/require.js',
				dest: './public/assets/js/'
			}
		]
	},
	production: {
		files: [
			{
				expand: true,
				cwd: "./app/frontend/images/",
				src: "**/**",
				dest: "./public/assets/img/"
			},
			{
				flatten: true,
				expand: true,
				src: './bower_components/font-awesome/fonts/*',
				dest: './public/assets/fonts/'
			},
			{
				flatten: true,
				expand: true,
				src: './bower_components/respond/dest/respond.min.js',
				dest: './public/assets/js/'
			},
			{
				flatten: true,
				expand: true,
				src: './bower_components/html5shiv/dist/html5shiv.min.js',
				dest: './public/assets/js/'
			}
		]
	}
}
