# Headless Craft CMS Starter

## Start a new project with DDEV

Read the DDEV [documentation](https://ddev.readthedocs.io/) to install it before proceeding.

```
mkdir my-craft-project
cd my-craft-project
ddev config --project-type=craftcms --database=mariadb:10.6
ddev composer create -y --no-install --no-scripts lg2/craft
ddev composer install
ddev craft install
ddev launch /admin
```
