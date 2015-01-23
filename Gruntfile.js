// Empty Gruntfile, refers to modules inside grunt folder
module.exports = function(grunt) {
	var path = require('path');
	require('load-grunt-config')(grunt, {
		configPath: path.join(process.cwd(), 'resources/grunt')
	});
	require('time-grunt')(grunt);
};
