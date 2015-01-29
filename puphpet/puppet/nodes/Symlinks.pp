if $symlinks == undef { $symlinks = hiera_hash('symlinks', false) }

each( $symlinks ) |$file, $target| {
  file { $file:
    ensure => 'link',
    target => $target,
    force => true
  }
}