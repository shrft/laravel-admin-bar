# Introduction

This package help you add Wordpress like admin bar to your Laravel application.
Admin bar is an easy-to-access toolbar to your admin pages.

![admin-bar](https://raw.githubusercontent.com/shrft/laravel-admin-bar/master/resources/images/adminbar-image.png)

# Supported Version

- laravel/framework >= 5.7

# Installation

To instal laravel-admin-bar, require it by Composer:
```
composer require shrft/laravel-admin-bar
```

Once Composer is done, run the following command:
```
php artisan vendor:publish --provider="Shrft\AdminBar\AdminBarServiceProvider"
```

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
        ),
);
```

# Advanced Configuration

### Generate path dynamically
You can pass a callback to `path` in the array `menus` and you can access `Illuminate\HttpRequest $request` within the callback so that you can generate link dynamically based on the current url. 

### How to add `edit this post` link in every post page

Assume you have the following 2 routes, the first one is for post pages and the second one is the edit page of the posts.

```php
# article page
Route::get('/post/{id}', ['uses'=>'PostController@show']);

# page to edit an article
Route::get('/admin/post/edit/{id}', ['uses'=>'Admin\PostController@edit']);

```

Then, you can do something like this.

```php
'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=>'edit this post',
         'path'=>function($request){
                    $postid = $request->route('id');
                    return '/admin/post/edit/' . $postid;
                 }, 
         'filter'=>'post/*'],
        ),
```

The `filter` is explained below. 
In the above, it means show `edit this post` link only when current page's path start with `post/`.

### Filter
You can configure Admin Bar so that a link show up only in a specific condition.

For example, if you want to show `Add Post` link only when you are visiting pages of which url path start with 'post/', you can set filter option like below.

```php
'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=>'Add Post', 'path'=>'/admin/post/new', 'filter'=>'post/*'],
        )
```
Admin Bar checks if the current url matches the path set in the filter with `Illuminate\Http\Request::is()` and show the link only when it returns true.

You can also pass callback to the filter option if you need more advanced configuration.

If you want to show `Add Post` link only to a user with role `author`, you might do something like this.

```php
'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=>'Add Post',
         'path'=>'/admin/post/new',
         'filter'=>function($request){
             return Auth::user()->isRole('author');
            }],
        )

```
You have access to `Illuminate\HttpRequest $request` in the callback here as well.

### Drop Down Menu
You can add drop down menu to Admin Bar.
To create drop down, pass an array to `path`.

```php
'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=>'Drop Down', 'path'=>[
                                 ['title'=>'Option1', 'path'=>'/path/to/option1'],
                                 ['title'=>'Option2', 'path'=>'/path/to/option2']
                                ]
        ],
        ),
```

# Lincense

Laravel Admin Bar is open-sourced software licensed under the MIT license.
