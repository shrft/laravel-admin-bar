<?php

return [
    /*
     *
     * Change this to false to disable admin bar
     *
     * */
    'enabled'=> true,

    /*
     *
     * Please specify your admin pages' url so that Admin Bar does not show up in
     * your admin pages.
     *
     * The default is 'admin/*'
     * When loading Admin Bar, It checks if current url matches the path set here with Illuminate\Http\Request::is().
     *
     * */
    'excludes' => 'admin/*',

    /*
     *
     * In order to show Admin Bar only for logged in admin users,
     * please specify how to tell if current visitor is logged in and also an admin
     * user.
     *
     * As a default, we just return true.
     *
     * */
    'is_admin' => function () {
        // This is an example code.
        //
        // if( Auth::user() &&  Auth::user()->isAdmin()){
        //     return true;
        // }
        // return false;

        return true;
    },

    /*
     *
     * Specify links to show on Admin Bar.
     *
     * */
    'menus' => [
        ['title'=>'Admin Top', 'path'=>'/admin'],
        ['title'=> 'Add a post', 'path'=>'/admin/post/new'],
        // you can pass callback to the path
        ['title'=> 'Edit a post', 'path'=>function ($request) {
            // this is an example of how you generate pass dynamically.

            if ($request->is('post/*')) {
                $postid = $request->route('id');

                return '/admin/post/edit/'.$postid;
            }

            // if you return false, this link is not displayed.
            return false;
        }],
        // pass an array to path for dropdown menu.
        ['title'=> 'Drop Down', 'path'=>[
                                 ['title'=>'Option1', 'path'=>'/path/to/option1'],
                                 ['title'=> 'Option2', 'path'=>'/path/to/option2'],
                                ],
        ],
        ],
];
