"user strict"
const viewModel = [{
    path: '/',
    componentUrl: './pages/auth.php',
}, {
    path: '/login/',
    componentUrl: './pages/login.php',
}, {
    path: '/navi/:level/',
    componentUrl: './pages/navi.php',
    master: true,
    detailRoutes: [{
        path: '/dashboard/',
        componentUrl: './pages/dashboard.php',
    }, {
        path: '/checkpoint/',
        componentUrl: './pages/checkpoint.php',
    }, {
        path: '/report/',
        componentUrl: './pages/report.php',
    }, {
        path: '/person/',
        componentUrl: './pages/person.php',
    }, {
        path: '/users/',
        componentUrl: './pages/users.php',
    }, {
        path: '/schedule/',
        componentUrl: './pages/schedule.php',
    }]
}, {
    path: '(.*)',
    url: './pages/404.php',
}]