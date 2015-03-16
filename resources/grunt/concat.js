module.exports = {
	all: {
		options: {
			separator: ';\n'
		},
		src: [
			'./bower_components/jquery/jquery.min.js',
			'./bower_components/bootstrap/dist/js/bootstrap.min.js',
			'./bower_components/jquery-form/jquery.form.js',
			'./bower_components/select2/select2.min.js',
			'./resources/javascript/site.js'
		],
		dest: './public/assets/js/site.min.js'
	}
};