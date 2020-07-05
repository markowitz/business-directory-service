import AdminLayout from './components/AdminLayout';
import Home from './components/Home';
import Listings from './components/Listings';
import Categories from './components/Categories';
import Login from './components/Login';
import SearchListings from './components/SearchListings';
import ViewListing from './components/ViewListing';
import { authProtect, middleware, redirect, guest } from './middleware';

export default {
    mode: 'history',
    linkActiveClass: 'active',

    routes: [
        {
            path: '/admin',
            component: AdminLayout,
            beforeEnter: middleware([authProtect, redirect]),
            children: [
                {
                    path: '/',
                    component: Listings
                },
                {
                    path: 'categories',
                    component: Categories
                }
            ]
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/admin/login',
            component: Login,
            beforeEnter: middleware([guest])
        },
        {
            path: '/search',
            component: SearchListings,
        },
        {
            path: '/listing/:id',
            component: ViewListing,
            name: 'view listing'
        }


    ]
}