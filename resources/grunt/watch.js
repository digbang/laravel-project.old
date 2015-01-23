module.exports = {
	options: {
		livereload: true
	},
	requirejs: {
		files: ["./app/frontend/javascript/**/*.js"],
		tasks: "requirejs"
	},
	less: {
		files: ["./app/frontend/stylesheets/**/*.less"],
		tasks: "less"
	},
	images: {
		files: ["./app/frontend/images/**"],
		tasks: "copy:production"
	},
	dependencies: {
		files: ["./bower_components/*"],
		tasks: "all"
	},
	configFiles: {
		files: ["Gruntfile.js", "grunt/*.js", "grunt/aliases.yaml"],
		options: {
			reload: true
		},
		tasks: "all"
	},
	php_specs: {
		files: ["tests/**/*Spec.php", "app/**/*.php"],
		tasks: ["specs"]
	}
};