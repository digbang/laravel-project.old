#!/bin/bash
# Directory in which librarian-puppet should manage its modules directory
PUPPET_DIR=/etc/puppet/

cp "/vagrant/vagrant-config/Puppetfile" "$PUPPET_DIR"
echo 'Copied Puppetfile, running update librarian-puppet'
cd "$PUPPET_DIR" && librarian-puppet update >/dev/null
echo 'Finished running update librarian-puppet'