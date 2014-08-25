# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "laravel-base"
  #config.vm.box_url = "file:////STORAGE/ImasD/Vagrant-boxes/laravel-base.box"
  config.vm.box_url = "~/virtualbox-exports/laravel-base/laravel-base.box"

  config.vm.network "private_network", ip: "10.1.2.5"
  
  config.vm.network :forwarded_port, guest: 80, host: 8080, id: "http", auto_correct: true
  config.vm.network :forwarded_port, guest: 8983, host: 8983, id: "solr", auto_correct: true
  
  if defined? VagrantPlugins::VagrantWinNFSd
    config.vm.synced_folder ".", "/vagrant", type: "nfs"
	config.winnfsd.uid = 1
	config.winnfsd.gid = 1
  end

  config.vm.provider :virtualbox do |virtualbox|
    virtualbox.customize ["modifyvm", :id, "--name", "project-name-box"]
    virtualbox.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    virtualbox.customize ["modifyvm", :id, "--memory", "3072"]
    virtualbox.customize ["modifyvm", :id, "--pae", "on"]
    virtualbox.customize ["setextradata", :id, "--VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
  end
  
  config.vm.provision :shell, :path => "vagrant-config/shell/librarian-puppet-vagrant.sh"
  config.vm.provision :puppet do |puppet|
    puppet.facter = {
      "ssh_username" => "vagrant"
    }

	puppet.manifests_path = "vagrant-config/puppet/manifests"
    puppet.options = [
	    "--verbose",
	    "--hiera_config /vagrant/vagrant-config/hiera.yaml",
	    "--parser future"
	]
  end

  config.ssh.username = "vagrant"

  config.ssh.shell = "bash -l"

  config.ssh.keep_alive = true
  config.ssh.forward_agent = false
  config.ssh.forward_x11 = false
  config.vagrant.host = :detect
  #config.vbguest.auto_update = false

end
