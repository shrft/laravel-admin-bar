<?php

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
