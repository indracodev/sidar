"user strict"
const viewModel = [{
    path: '/',
    componentUrl: `./pages/auth.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
}, {
    path: '/login/',
    componentUrl: `./pages/login.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
}, {
    path: '/navi/:level/',
    componentUrl: `./pages/navi.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    master: true,
    detailRoutes: [{
        path: '/dashboard/',
        componentUrl: `./pages/dashboard.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/checkpoint/',
        componentUrl: `./pages/checkpoint.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/report/',
        componentUrl: `./pages/report.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/person/',
        componentUrl: `./pages/person.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/users/',
        componentUrl: `./pages/users.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/logs/',
        componentUrl: `./pages/logs.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/task/',
        componentUrl: `./pages/task.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }, {
        path: '/schedule/:level/',
        componentUrl: `./pages/schedule.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
    }]
}, {
    path: '(.*)',
    url: `./pages/404.html?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`,
}]