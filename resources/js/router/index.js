// resources/js/router.js

import { createRouter, createWebHistory } from 'vue-router'
import store from '../store'; // Import Vuex store

// Authentication
import Login from '../components/auth/login.vue'
import Register from '../components/auth/register.vue'
import RequestForm from '../components/pages/requestForm.vue'
// import Login from '../components/auth/login.vue'

// Dashboard
import AdminNav from '../components/dashboard/adminNav.vue'
import Home from '../components/dashboard/admin/home.vue'
import Personnel from '../components/dashboard/admin/personnel.vue'


import Main from '../components/main.vue'

const routes = [
  {
    path: '/',
    component: Main,
  },
  {
    name: 'login',
    path: '/login',
    component: Login,
  },
  {
    name: 'register',
    path: '/register',
    component: Register,
  },
  {
    name: 'requestForm',
    path: '/requestForm',
    component: RequestForm,
  },
  {
    path: '/dashboard',
    component: AdminNav,
    meta: { requiresAuth: true },
    children: [
        {
            name: 'home',
            path: 'main',
            component: Home ,
        },
        {
            name: 'personnel',
            path: 'personnel',
            component: Personnel,
        },
    ]
},
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0, behavior: 'smooth' }
    }
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.getters.isAuthenticated;
    const userRole = localStorage.getItem('userRole');

    if (to.meta.requiresAuth && !isAuthenticated) {
        if (to.name !== 'login') {
            next({ name: 'login' });
        } else {
            next();
        }
    } else if (isAuthenticated && to.name === 'login') {
        next({ path: '/dashboard/main' });
    } else {
        if (to.matched.some(record => record.meta.role)) {
            const requiredRole = to.matched.find(record => record.meta.role).meta.role;
            if (userRole === requiredRole) {
                next();
            } else {
                next({ path: '/unauthorized' });
            }
        } else {
            next();
        }
    }

    // if dashboard link is reload/enter, go back to the previous path/link
});

export default router;
