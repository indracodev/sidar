"user strict"
const viewModel = [{
    path: '/',
    componentUrl: './pages/auth.html',
}, {
    path: '/login/',
    componentUrl: './pages/login.html',
}, {
    path: '/navi/:level/',
    componentUrl: './pages/navi.html',
    master: true,
    detailRoutes: [{
        path: '/dashboard/',
        componentUrl: './pages/dashboard.html',
    }, {
        path: '/checkpoint/',
        componentUrl: './pages/checkpoint.html',
    }, {
        path: '/report/',
        componentUrl: './pages/report.html',
    }, {
        path: '/person/',
        componentUrl: './pages/person.html',
    }, {
        path: '/users/',
        componentUrl: './pages/users.html',
    }, {
        path: '/task/',
        componentUrl: './pages/task.html',
    }, {
        path: '/schedule/',
        componentUrl: './pages/schedule.html',
    }]
}, {
    path: '(.*)',
    url: './pages/404.html',
}]