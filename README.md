# Neos CMS Comments/Guestbook Plugin

A Neos CMS comments/guestbook plugin which has integrated Gravatar for the user/commentators profile images. 
You can decide if you want to use Gravatar or not (look at Settings.yaml further down).

## Installation

The NeosRulez.Comments package is listed on packagist (https://packagist.org/packages/neosrulez/comments) - therefore you don't have to include the package in your "repositories" entry any more.

Just add the following line to your require section:

```
"neosrulez/comments": "*"
```

And the run this command to fetch the plugin:

```
composer update
```

## Settings.yaml

Define your required settings in the Settings.yaml of your own site package.

```
NeosRulez:
  Comments:
    usingGravatar: true
    gravatarImgSize: '64'
    sendMails: true
    adminName: 'Admin Name'
    adminMail: 'admin@yourdomain.com'
    mailSubject: 'Comment'
```

## Author

* E-Mail: mail@patriceckhart.com 
* URL: http://www.patriceckhart.com 