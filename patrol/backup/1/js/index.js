"user strict"
const storage = window.localStorage

const toast = function (msg) {
    app.toast.create({
        text: msg,
        closeTimeout: 2000,
    }).open()
}

Framework7.use(debugPlugin)

const app = new Framework7({
    el: '#app',
    theme: 'aurora',
    name: 'Patrol',
    debugger: false,
    panel: {
        swipe: true,
    },
    routes: viewModel,
    popup: {
        closeOnEscape: true,
    },
    sheet: {
        closeOnEscape: true,
    },
    popover: {
        closeOnEscape: true,
    },
    actions: {
        closeOnEscape: true,
    },
})