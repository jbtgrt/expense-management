import { createRouter, createWebHistory } from "vue-router";

// Layouts :
	import DefaultLayout from './layouts/DefaultLayout.vue';
	import AuthLayout from './layouts/AuthLayout.vue';
// Admin Pages :
	import Dashboard from './pages/Dashboard.vue';
    import Login from './pages/Login.vue';
    // import Register from './pages/Register.vue';
    import Roles from './pages/Roles.vue';
    import Users from './pages/Users.vue';
    import ExpenseCategories from './Pages/ExpenseCategories.vue';
    import Expenses from './pages/Expenses.vue';
	import Profile from './pages/Profile.vue';



import store from './store.js';

const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        component: DefaultLayout,
        meta: {requiresAuth: true },
        children: [
            { 
                path: '/dashboard', 
                name: 'Dashboard', component: Dashboard
            },
            { 
                path: '/profile', 
                name: 'Profile', component: Profile
            },
            { 
                path: '/user-management',
                name: 'User Management',
                redirect: '/roles',
                meta: {requiresAdmin: true }, 
                children: [
                    { 
                        path: '/roles', 
                        name: 'Roles', 
                        component: Roles },
                    { 
                        path: '/users', 
                        name: 'Users', 
                        component: Users },
                ]
            },
            { 
                path: '/expense-management',
                name: 'Expense Management',
                redirect: '/expense-categories', 
                children: [
                    { 
                        path: '/expense-categories', 
                        name: 'Expense Categories', 
                        component: ExpenseCategories, 
                        meta: {requiresAdmin: true }, 
                    },
                    { 
                        path: '/expenses', 
                        name: 'Expenses', 
                        component: Expenses,
                    },
                ]
            },
        ]
    },
    {
      path: '/auth',
        redirect: '/login',
        component: AuthLayout,
        meta: {isGuest: true},
        children: [
            { path: '/login', name: 'Login', component: Login},
            // { path: '/register', name: 'Register', component: Register},
        ]
    }, 
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  linkActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token){
        next({name: 'Login'});
    } else if (store.state.user.token && (to.meta.isGuest)) {
        next({name: 'Dashboard'});
    } else if (to.meta.requiresAdmin && !store.state.user.admin) {
        next({name: 'Dashboard'});
    } else {
        next()
    }
});

export default router;