#!/bin/bash
#hotfix for CentOS 6.5 repos: https://github.com/puphpet/puphpet/issues/2321
/usr/bin/yum -y remove centos-release-SCL
/usr/bin/yum -y install centos-release-scl