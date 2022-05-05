<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['MemeController', 'index',],
    'register' => ['UserController', 'register',],
    'login' => ['UserController', 'login',],
    'logout' => ['UserController', 'logout',],
    'welcome' => ['UserController', 'welcome',],
    'legals' => ['HomeController', 'legals',],
    'create' => ['MemeController', 'add',],
    'meme/edit' => ['MemeController', 'edit', ['id']],
    'meme/show' => ['MemeController', 'show', ['id']],
    'vote' => ['VoteController', 'showVoteId', ['id']],
    'meme' => ['VoteController', 'memeVote', ['id']],
    'meme/add' => ['MemeController', 'add',],
    'meme/delete' => ['VoteController', 'delete',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
];
