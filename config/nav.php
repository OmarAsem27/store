<?php


return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'link' => 'dashboard.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.dashboard'
    ],
    [
        'icon' => 'nav-icon far fa-circle',
        'link' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'nav-icon far fa-circle',
        'link' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'nav-icon fas fa-receipt',
        'link' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.view',
    ],
    [
        'icon' => 'nav-icon fas fa-shield-alt',
        'link' => 'dashboard.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
    ],
    [
        'icon' => 'nav-icon fas fa-users',
        'link' => 'dashboard.users.index',
        'title' => 'Users',
        'active' => 'dashboard.users.*',
        'ability' => 'users.view',
    ],
    [
        'icon' => 'nav-icon fas fa-users',
        'link' => 'dashboard.admins.index',
        'title' => 'Admins',
        'active' => 'dashboard.admins.*',
        'ability' => 'admins.view',
    ],
];
