## Begin Server manifest

if $server_values == undef {
  $server_values = hiera('server', false)
}

# Ensure the time is accurate, reducing the possibilities of apt repositories
# failing for invalid certificates
include '::ntp'
include 'nodejs'

group { 'puppet': ensure => present }
Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/', '/usr/local/bin' ] }
File { owner => 0, group => 0, mode => 0644 }

user { $::ssh_username:
    shell  => '/bin/bash',
    home   => "/home/${::ssh_username}",
    ensure => present
}

file { "/home/${::ssh_username}":
    ensure => directory,
    owner  => $::ssh_username,
    recurse => true
}

file { "/var/www/html/local.project-name.db":
    ensure => 'link',
    target => '/vagrant/public'
}

exec { "run_vbox_add":
    command => "sudo /etc/init.d/vboxadd setup",
    unless => "lsmod | grep vboxsf",
}

# in case php extension was not loaded
if $php_values == undef {
  $php_values = hiera('php', false)
}

class { 'yum': extrarepo => ['epel'] }

Class['::yum'] -> Yum::Managed_yumrepo <| |> -> Package <| |>

exec { 'bash_git':
  cwd     => "/home/${::ssh_username}",
  command => "curl https://raw.github.com/git/git/master/contrib/completion/git-prompt.sh > /home/${::ssh_username}/.bash_git",
  creates => "/home/${::ssh_username}/.bash_git"
}

file_line { 'link ~/.bash_git':
  ensure  => present,
  line    => 'if [ -f ~/.bash_git ] ; then source ~/.bash_git; fi',
  path    => "/home/${::ssh_username}/.bash_profile",
  require => [
    Exec['bash_git'],
  ]
}

file_line { 'link ~/.bash_aliases':
  ensure  => present,
  line    => 'if [ -f ~/.bash_aliases ] ; then source ~/.bash_aliases; fi',
  path    => "/home/${::ssh_username}/.bash_profile",
  require => [
    File_line['link ~/.bash_git'],
  ]
}

ensure_packages( ['augeas'] )

if is_hash($php_values) {
  if $php_values['version'] == '54' {
    class { 'yum::repo::remi': }
  }
  # remi_php55 requires the remi repo as well
  elsif $php_values['version'] == '55' {
    class { 'yum::repo::remi': }
    class { 'yum::repo::remi_php55': }
  }
}

if !empty($server_values['packages']) {
  ensure_packages( $server_values['packages'] )
}

service { 'redis':
    require => Package['redis'],    
    ensure => running,
    enable => true,
    hasrestart => true,
    hasstatus => true
}

service { 'memcached':
    require => Package['memcached'],
    ensure => running,
    enable => true,
    hasrestart => true,
    hasstatus => true
}

define add_dotdeb ($release){
   apt::source { $name:
    location          => 'http://packages.dotdeb.org',
    release           => $release,
    repos             => 'all',
    required_packages => 'debian-keyring debian-archive-keyring',
    key               => '89DF5277',
    key_server        => 'keys.gnupg.net',
    include_src       => true
  }
}

## Begin Apache manifest

if $apache_values == undef {
  $apache_values = hiera('apache')
}

class { 'apache':
  manage_user   => false,
  user          => $apache_values['user'],
  group         => $apache_values['group'],
  default_vhost => $apache_values['default_vhost'],
  mpm_module    => $apache_values['mpm_module'],
  sendfile      => $apache_values['sendfile']
}

if ! defined(Iptables::Allow['tcp/80']) {
  iptables::allow { 'tcp/80':
    port     => '80',
    protocol => 'tcp'
  }
}

apache::vhost { 'local.project-name.db':
  servername  => 'local.project-name.db',
  serveradmin => 'infraestructura@digbang.com',
  docroot     => '/var/www/html/local.project-name.db',
  port        => '80',
  setenv      => [
    'APP_ENV local'
  ],
  override    => [
    'All'
  ],
  rewrites    => [
    {
      'rewrite_rule' => '^(.+[^/])/$ $1 [R=301,L]'
    },
    {
      'rewrite_cond' => ['%{DOCUMENT_ROOT}%{REQUEST_URI} !-d', '%{DOCUMENT_ROOT}%{REQUEST_URI} !-f'],
      'rewrite_rule' => '. /index.php [L]'
    }
  ]
}

define apache_mod {
  if ! defined(Class["apache::mod::${name}"]) {
    class { "apache::mod::${name}": }
  }
}

if count($apache_values['modules']) > 0 {
  apache_mod { $apache_values['modules']: }
}
  
## Begin PHP manifest

if $nginx_values == undef {
  $nginx_values = hiera('nginx', false)
}

Class['Php'] -> Class['Php::Devel'] -> Php::Module <| |> -> Php::Pear::Module <| |> -> Php::Pecl::Module <| |>

if $php_prefix == undef {
  $php_prefix = $::operatingsystem ? {
    /(?i:Ubuntu|Debian|Mint|SLES|OpenSuSE)/ => 'php5-',
    default                                 => 'php-',
  }
}

if $php_fpm_ini == undef {
  $php_fpm_ini = $::operatingsystem ? {
    /(?i:Ubuntu|Debian|Mint|SLES|OpenSuSE)/ => '/etc/php5/fpm/php.ini',
    default                                 => '/etc/php.ini',
  }
}

if is_hash($apache_values) {
  $php_webserver_service = 'httpd'

  class { 'php':
    service => $php_webserver_service
  }
} elsif is_hash($nginx_values) {
  $php_webserver_service = "${php_prefix}fpm"

  class { 'php':
    package             => $php_webserver_service,
    service             => $php_webserver_service,
    service_autorestart => false,
    config_file         => $php_fpm_ini,
  }

  service { $php_webserver_service:
    ensure     => running,
    enable     => true,
    hasrestart => true,
    hasstatus  => true,
    require    => Package[$php_webserver_service]
  }
}

class { 'php::devel': }

if count($php_values['modules']['php']) > 0 {
  php_mod { $php_values['modules']['php']:; }
}
if count($php_values['modules']['pecl']) > 0 {
  php_pecl_mod { $php_values['modules']['pecl']:; }
}
if count($php_values['ini']) > 0 {
  each( $php_values['ini'] ) |$key, $value| {
    puphpet::ini { $key:
      entry       => "CUSTOM/${key}",
      value       => $value,
      php_version => $php_values['version'],
      webserver   => $php_webserver_service
    }
  }
}

define php_mod {
  php::module { $name: }
}
define php_pear_mod {
  php::pear::module { $name: use_package => false }
}
define php_pecl_mod {
  php::pecl::module { $name: 
    use_package => false
  }
}

if $php_values['composer'] == 1 {
  class { 'composer':
    target_dir      => '/usr/local/bin',
    composer_file   => 'composer',
    download_method => 'curl',
    logoutput       => false,
    tmp_path        => '/tmp',
    php_package     => "${php::params::module_prefix}cli",
    curl_package    => 'curl',
    suhosin_enabled => false
  }
}

if $xdebug_values == undef {
  $xdebug_values = hiera('xdebug', false)
}

if is_hash($apache_values) {
  $xdebug_webserver_service = 'httpd'
} elsif is_hash($nginx_values) {
  $xdebug_webserver_service = 'nginx'
} else {
  $xdebug_webserver_service = undef
}

if $xdebug_values['install'] != undef and $xdebug_values['install'] == 1 {
  class { 'puphpet::xdebug':
    webserver => $xdebug_webserver_service
  }

  if is_hash($xdebug_values['settings']) and count($xdebug_values['settings']) > 0 {
    each( $xdebug_values['settings'] ) |$key, $value| {
      puphpet::ini { $key:
        entry       => "XDEBUG/${key}",
        value       => $value,
        php_version => $php_values['version'],
        webserver   => $xdebug_webserver_service
      }
    }
  }
}

## Begin PostgreSQL manifest

if $postgresql_values == undef {
  $postgresql_values = hiera('postgresql', false)
}

if $postgresql_values['root_password'] {
  group { $postgresql_values['user_group']:
    ensure => present
  }
  
  class { 'postgresql::globals':
    manage_package_repo => true,
    version             => $postgresql_values['version']
  }
  
  class { 'postgresql::server':
    require            => Group[$postgresql_values['user_group']],
    postgres_password  => $postgresql_values['root_password'],
    listen_addresses   => $postgresql_values['listen_addresses'],
    needs_initdb       => true,
    manage_pg_hba_conf => true
  }

  if count($postgresql_values['roles']) > 0 {
    create_resources(postgresql::server::role, $postgresql_values['roles'])
  }
  
  if count($postgresql_values['databases']) > 0 {
    each ($postgresql_values['databases']) | $key, $database | {
      $name     = $database['name']
      $owner    = $database['owner']
      $grant    = $database['grant']
      $sql_file = $database['sql_file']
      
      postgresql::server::database { $name:
        require => Postgresql::Server::Role[$owner],
        dbname => $name,
        owner => $owner
      }
      
      postgresql::server::database_grant { "GRANT ${owner} - ${grant} - ${name}":
        privilege => $grant,
        db        => $name,
        role      => $owner,
      }
      
      if $sql_file {
        $ownerPassword = $postgresql_values['roles'][$owner]['password_hash']
        $table = "${name}.*"
    
        exec { "${name}-import":
          require     => Postgresql::Server::Database[$name],
          environment => ["PGPASSWORD=${ownerPassword}", 'PGHOST=localhost', 'PGUSER=${owner}'],
          command     => "psql '${name}' < ${sql_file}",
          logoutput   => true,
          refreshonly => $refresh,
          onlyif      => "test -f ${sql_file}"
        }
      }
    }
    
    postgresql::server::pg_hba_rule { 'allow application network to access deployer database':
      description => "Open up postgresql for access from everywhere",
      type => 'host',
      database => 'all',
      user => 'all',
      address => '0.0.0.0/0',
      auth_method => 'md5',
    }
  }
  
  if ! defined(Iptables::Allow['tcp/5432']) {
    iptables::allow { 'tcp/5432':
      port     => '5432',
      protocol => 'tcp'
    }
  }
}

$solr = hiera('solr')
service { 'solr':
  enable => $solr['enabled'],
  hasrestart => true,
  hasstatus => false
}

if ! defined(Iptables::Allow['tcp/8983']) {
  iptables::allow { 'tcp/8983':
    port     => '8983',
    protocol => 'tcp'
  }
}