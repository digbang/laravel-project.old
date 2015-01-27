module.exports = {
	images: {
		files: [
			{
				expand: true,
				cwd: "./app/frontend/images/",
				src: "**/**",
				dest: "./public/assets/img/"
			}
		]
	},
	fonts: {
		files: [
			{
				flatten: true,
				expand: true,
				src: './bower_components/font-awesome/fonts/*',
				dest: './public/assets/fonts/'
			}
		]
	},
	js: {
		files: [
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
};
