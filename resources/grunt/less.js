module.exports = {
	production: {
		options: {
			compress: true,
			sourceMap: true,
			cleancss: false
		},
		expand: true,
		cwd: "./resources/stylesheets/",
		src: "site.less",
		dest: "./public/assets/css/",
		ext: ".min.css"
	}
}
