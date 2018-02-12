import VueRouter from 'vue-router'
import { STORAGE_AUTH } from '../store/auth'
import Login from '../views/auth/Login.vue'
import Admin from '../components/Admin.vue'
import Dashboard from '../views/dashboard/Dashboard.vue'
import AdminMenu from '../views/menu/AdminMenu.vue'
import AdminCategory from '../views/category/AdminCategory.vue'

import AdminProduct from '../views/product/AdminProduct.vue'
import AdminProductAdd from '../views/product/AdminProductAdd.vue'
import AdminProductEdit from '../views/product/AdminProductEdit.vue'

import AdminPost from '../views/post/AdminPost.vue'
import AdminPostAdd from '../views/post/AdminPostAdd.vue'
import AdminPostEdit from '../views/post/AdminPostEdit.vue'

import AdminBanner from '../views/banner/AdminBanner.vue'

import AdminSetup from '../views/setup/AdminSetup.vue'

const router =  new VueRouter({
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
            component: Admin,
            name: 'Trang chủ',
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'dashboard',
                    name: 'Quản lý',
                    component: Dashboard
                },
                {
                    path: 'menus',
                    name: 'Menus',
                    component: AdminMenu
                },
                {
                    path: 'categories',
                    name: 'Danh mục',
                    component: AdminCategory
                },
                {
                    name: 'Sản phẩm',
                    path: '/',
                    redirect: 'products',
                    component: {
                        render(c) { 
                            return c('router-view')
                        }
                    },
                    children: [
                        {
                            path: 'products',
                            name: 'Danh sách sản phẩm',
                            component: AdminProduct
                        },
                        {
                            path: 'products/add',
                            name: 'Thêm mới sản phẩm',
                            component: AdminProductAdd
                        },
                        {
                            path: 'products/edit/:id',
                            name: 'Cập nhật sản phẩm',
                            component: AdminProductEdit
                        }
                    ]
                },
                {
                    name: 'Bài viết',
                    path: '/',
                    redirect: 'posts',
                    component: {
                        render(c) { 
                            return c('router-view')
                        }
                    },
                    children: [
                        {
                            path: 'posts',
                            name: 'Danh sách bài viết',
                            component: AdminPost
                        },
                        {
                            path: 'posts/add',
                            name: 'Thêm mới bài viết',
                            component: AdminPostAdd
                        },
                        {
                            path: 'posts/edit/:id',
                            name: 'Cập nhật bài viết',
                            component: AdminPostEdit
                        }
                    ]
                },
                {
                    name: 'Banners',
                    path: 'banners',
                    component: AdminBanner
                },
                {
                    name: 'Cài đặt',
                    path: 'setups',
                    component: AdminSetup
                },
            ]
        },
        {
            path: '/login',
            name: 'Đăng nhập',
            component: Login
        }
        // {
        //     path: '/*',
        //     redirect: '/dashboard'
        // },
    ]

});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        const auth = JSON.parse(window.localStorage.getItem(STORAGE_AUTH)) || {};

        if (!auth || !auth.token || !auth.token.access_token) {
            return next({ path: '/login' })
        }
    }

    return next();
})

export default router;
