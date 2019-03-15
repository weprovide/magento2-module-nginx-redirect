# magento2-module-nginx-redirect

Compatible with Magento 2.1.12 and higher.

## Installation

1. composer require weprovide/module-nginxredirect
2. bin/magento setup:upgrade

## Configuration

You'll need to configure the complete path of your nginx config file in which you wish to write the redirects. You can find this in the following configuration.
 
`Admin > Stores > Configuration > We Provide > Nginx Redirect > Path > Config Path`

You can set up your redirects under the following grid.
 
`Admin > Marketing > Nginx Redirects`

## Cron

A cron, which runs twice a day, will generate a fresh file with all redirects. You'll need to manually reload nginx on your webserver.

If you wish you can manually trigger the cron, if you have magerun2 installed, with the following command.

`magerun2 sys:cron:run nginx_redirect_write`
