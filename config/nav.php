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
        'active' => 'dashboard.categories.*'
    ],
    [
        'icon' => 'nav-icon far fa-circle',
        'link' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*'
    ],
    [
        'icon' => 'nav-icon far fa-circle',
        'link' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*'
    ],

];
