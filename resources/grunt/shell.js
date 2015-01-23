var grunt = require('grunt');
module.exports = {
	phpspec: {
		command: 'vendor/bin/phpspec run -n --no-ansi',
		options: {
			callback: function(err, stdout, stderr, cb){
				if (err) {
					grunt.fail.warn(
						"PHPSpec tests failed" + "\n\n" + stdout.replace('\\', '\\\\'),
						err.code
					);
				}

				cb(err, stdout, stderr);
			}
		}
	}
};