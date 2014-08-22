module.exports = {
	build: ['copy:production', 'less:production', 'requirejs'],
	dev: ['copy:development', 'symlink'],
	all: ['copy', 'less:production', 'requirejs', 'symlink']
}