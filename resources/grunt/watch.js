module.exports = {
	options: {
		livereload: true
	},
	requirejs: {
		files: ["./resources/javascript/**/*.js"],
		tasks: "concat"
	},
	less: {
		files: ["./resources/stylesheets/**/*.less"],
		tasks: "less"
	},
	images: {
		files: ["./resources/images/**"],
		tasks: "copy:images"
	},
	dependencies: {
		files: ["./bower_components/*"],
		tasks: "build"
	},
	configFiles: {
		files: ["Gruntfile.js", "grunt/*.js", "grunt/aliases.yaml"],
		options: {
			reload: true
		},
		tasks: "build"
	}
};