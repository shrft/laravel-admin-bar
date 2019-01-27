<?php
return array(
    'enabled'=>true,
    //this applies to all routes. if you want to exclude specific route, please use filter.
    'excludes' => 'admin/*',
    'is_admin' => function(){
        return true;
    },
    'menus' => array(
        ['title'=>'Admin Top', 'path'=>'/path/to/admin/top'],
        ['title'=>'Edit Post', 'path'=>'/edit/post_id'],
        ['title'=>'Sub Menu', 'path'=>[
                             ['title'=>'Option1', 'path'=>'/path/to/option1'],
                             ['title'=>'Option2', 'path'=>'/path/to/option2']
                            ]
        ]
        ),
);