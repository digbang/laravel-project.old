module.exports = {
	options: {
		overwrite: true
	},
	expanded: {
		files: [
			{
				expand: true,
				cwd: './app/frontend/javascript',
				src: ['*', '!README.md'],
				dest: './public/assets/js/src/'
			},
			{
				expand: true,
				cwd: './app/frontend/stylesheets',
				src: ['*', '!README.md'],
				dest: './public/assets/css/src/'
			}
		]
	}
}
