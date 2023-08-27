const routes = [
    {
        path: '/login',
        name: 'login',
        component: () => import("@/pages/Auth/Login.vue"),
        meta: { public: true },
    },
    {
        path: "/",
        name: "layout",
        redirect: '/dashboard',
        component: () => import("@/pages/Layouts.vue"),
        children: [
            {
                meta: { title: "Dashboard", menu: 'dashboard' },
                path: "/dashboard",
                name: "dashboard",
                component: () => import('@/pages/Dashboard/Main.vue'),
            },
            {
                meta: { title: "Data Medis", menu: 'datamedis' },
                path: "/data-medis",
                name: "datamedis",
                component: () => import('@/pages/Datamedis/Main.vue'),
            },
            {
                meta: { title: "Analisa", menu: 'cluster' },
                path: "/cluster",
                name: "cluster",
                component: () => import('@/pages/Cluster/Main.vue'),
            },
            {
                meta: { title: "Users", menu: 'users' },
                path: "/users",
                name: "users",
                component: () => import('@/pages/Users/Main.vue'),
            },
            {
                meta: { title: "Profil", menu: 'profil' },
                path: "/profil",
                name: "profil",
                component: () => import('@/pages/Profil/Main.vue'),
            },
        ]
    }
]

export default routes