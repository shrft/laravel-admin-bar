# Introduction

This package help you add wordpress like admin bar to your Laravel application.
Admin bar is an easy-to-access toolbar to your admin pages.

[admin bar image]

# Supported Version

work in progress...

# Installation

To instal laravel-admin-bar, require it by Composer:
```
composer require shrft/laravel-admin-bar
```

Once Composer is done, run the following command:
```
php artisan vendor:publish --provider=Shrft\\AdminBar\\AdminBarServiceProvider
```

# Basic Usage

When you are reading an article, 
You can configure how and when admin bar should be shown via the configuration file called `adminbar.php`.
If you have already run the publish command above, you should already have this file under config directory.

The following is the default setup of the `adminbar.php`
You can learn how to configure Admin Bar from the doc block of this file.

```php
return array(
    /**
     *  
     * Change this to false to disable admin bar
     * 
     * */
    'enabled'=>true,
    /**
     * 
     * Please specify your admin pages' url so that Admin Bar does not show up in 
     * your admin pages. 
     * 
     * The default is 'admin/*' which means url path start with 'admin'
     *  
     * */
    'excludes' => 'admin/*',
    /**
     * 
     * In order to show Admin Bar only for logged in admin user,
     * Please specify how to tell if current visitor is logged in and also an admin 
     * user.
     * 
     * As a default, we just return true.
     * 
     * */
    'is_admin' => function(){

       // This is an example code. 
       // 
       // if( Auth::user() &&  Auth::user()->isAdmin()){
       //     return true;
       // }
       // return false;
        
        return true;
    },
    /**
     * 
     * Here you may specify links to show on Admin Bar.
     * 
     * */
    'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=>'Add a post', 'path'=>'/admin/post/new'],
        ),
);
```

# Lincense

Wink is open-sourced software licensed under the MIT license.
