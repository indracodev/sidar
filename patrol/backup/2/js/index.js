"user strict"
const storage = window.localStorage

const toast = function (msg) {
    app.toast.create({
        text: msg,
        closeTimeout: 2000,
    }).open()
}

const app = new Framework7({
    el: '#app',
    theme: 'md',
    name: 'Patrol',
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