class puphpet_nodejs (
  $nodejs
) {
  if array_true($nodejs, 'settings')
    and array_true($nodejs['settings'], ['version'])
  {
    $version_num = $nodejs['settings']['version']
  } else {
    $version_num = '0.12'
  }

  $provider = $::osfamily ? {
    'debian' => 'deb',
    default  => 'rpm'
  }

  $version = $version_num ? {
    '5'     => 'latest-v5.x',
    '4'     => 'latest-v4.x',
    '0.12'  => 'latest-v0.12.x',
    '0.10'  => 'latest-v0.10.x',
    default => "latest"
  }

  $url = "https://${provider}.nodesource.com/${version}"

  $save_to = '/.puphpet-stuff/nodesource'

  file { '/.puphpet-stuff/nodejs_installer.sh':

    ensure => present,
    content => "#!/bin/bash
ARCH=$(uname -m)

if [ \"\${ARCH}\" == 'i386' ] || [ \"\${ARCH}\" == 'i686' ]; then
    FILENAME='linux-x86.tar.gz'
else
    FILENAME='linux-x64.tar.gz'
fi

LATEST_NODE=$(curl 'http://nodejs.org/dist/${version}/SHASUMS256.txt' | grep \"\${FILENAME}\" | awk '{ print \$2 }')
wget --quiet --tries=5 --connect-timeout=10 --no-check-certificate -O '/.puphpet-stuff/nodestable.tar.gz' \"http://nodejs.org/dist/${version}/\${LATEST_NODE}\"

cd '/usr/local/'

tar xzvf '/.puphpet-stuff/nodestable.tar.gz' --strip=1

ln -sf '/usr/local/bin/node' '/usr/bin/node'
ln -sf '/usr/local/bin/node' '/usr/bin/nodejs'
ln -sf '/usr/local/bin/npm' '/usr/bin/npm'
"
  }


  exec { 'install nodejs':
    command => "bash /.puphpet-stuff/nodejs_installer.sh",
    creates => '/usr/local/bin/node',
    path    => '/usr/bin:/bin',
    require => File['/.puphpet-stuff/nodejs_installer.sh']
  }

  each( $nodejs['npm_packages'] ) |$package| {
      $npm_array = split($package, '@')

      if count($npm_array) == 2 {
        $npm_ensure = $npm_array[1]
      } else {
        $npm_ensure = present
      }

    if ! defined(Package[$npm_array[0]]) {
      package { $npm_array[0]:
        ensure   => $npm_ensure,
        provider => npm,
        require  => Exec['install nodejs']
      }
    }
  }
}
