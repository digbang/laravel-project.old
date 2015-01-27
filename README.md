# Digbang / Laravel-Project
Digbang's Skeleton of a new Laravel project.

## Requirements

* PHP >= 5.5
* [git](http://git-scm.com)
* [composer](http://getcomposer.org)

## Usage

From a terminal (unix / windows with git bash):

```
mkdir NombreDelProyecto && cd NombreDelProyecto # Create a project folder
git archive --format tar --remote git@git.digbang.com:digbang/framework2-project master | tar -xf - # Download the skeleton
composer install # Download dependencies
vagrant up # install the virtual machine
```