import {createWebHistory, createRouter} from "vue-router"

import Home from "./pages/Home"
import Login from "./pages/Login"
import Equipment from "./pages/Equipment"
import CreateEquipment from "./components/equiments/Create"
import EditEquipment from "./components/equiments/Edit"

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'equipments',
        path: '/equipment',
        meta: {
            auth: true
        },
        component: Equipment
    },
    {
        name: 'createEquipment',
        path: '/equipment/create',
        meta: {
            auth: true
        },
        component: CreateEquipment
    },
    {
        name: 'editEquipment',
        path: '/equipment/:id',
        meta: {
            auth: true
        },
        component: EditEquipment
    },
];

const router = createRouter({
    history:createWebHistory(),
    routes:routes
})

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user')

    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/login')
        return
    }
    next()
})

export default router
