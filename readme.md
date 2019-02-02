# Introduction

This package help you add Wordpress like admin bar to your Laravel application.
Admin bar is an easy-to-access toolbar to your admin pages.

![admin-bar](https://raw.githubusercontent.com/shrft/laravel-admin-bar/master/resources/images/adminbar-image.png)

# Supported Version

- laravel/framework >= 5.5

# Installation

To instal laravel-admin-bar, require it by Composer:
```
composer require shrft/laravel-admin-bar
```

Once Composer is done, run the following command:
```
php artisan vendor:publish --provider="Shrft\AdminBar\AdminBarServiceProvider"
```

If you visit your page, you already have Admin bar!

# Basic Usage

You can configure how and when admin bar should be shown via the configuration file called `adminbar.php`.
If you have already run the publish command above, you should already have this file under the config directory.

The following is the default setup of the `adminbar.php`
You can learn how to configure Admin Bar from the doc blocks of this file.

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
     * The default is 'admin/*'
     * When loading Admin Bar, It checks if current url matches the path set here with Illuminate\Http\Request::is().
     *  
     * */
    'excludes' => 'admin/*',

    /**
     * 
     * In order to show Admin Bar only for logged in admin users,
     * please specify how to tell if current visitor is logged in and also an admin 
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
     * Specify links to show on Admin Bar.
     * 
     * */
    'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=>'Add a post', 'path'=>'/admin/post/new'],
        // you can pass callback to the path
        ['title'=>'Edit a post', 'path'=>function($request){

            // this is an example of how you generate pass dynamically.

            if($request->is('post/*')){
                $postid = $request->route('id');
                return '/admin/post/edit/' . $postid;
            }

            // if you return false, this link is not displayed.
            return false;
        }],
        // pass an array to path for dropdown menu.
        ['title'=>'Drop Down', 'path'=>[
                                 ['title'=>'Option1', 'path'=>'/path/to/option1'],
                                 ['title'=>'Option2', 'path'=>'/path/to/option2']
                                ]
        ],
        ),
);
```
# Lincense

Laravel Admin Bar is open-sourced software licensed under the MIT license.
