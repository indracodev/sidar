"user strict"
let debugEnabled = false
window.debugPlugin = {
    name: 'debugger',
    params: {
        debugger: false,
    },
    create: function () {
        let app = this
        app.debugger = {
            enable: function () {
                debugEnabled = true
            },
            disable: function () {
                debugEnabled = false
            },
        }
    },
    on: {
        init: function () {
            let app = this
            if (app.params.debugger) debugEnabled = true
            if(debugEnabled) console.log('app init')
        },
        pageBeforeIn: function (page) {
            if(debugEnabled) console.log('pageBeforeIn', page)
        },
        pageAfterIn: function (page) {
            if(debugEnabled) console.log('pageAfterIn', page)
        },
        pageBeforeOut: function (page) {
            if(debugEnabled) console.log('pageBeforeOut', page)
        },
        pageAfterOut: function (page) {
            if(debugEnabled) console.log('pageAfterOut', page)
        },
        pageInit: function (page) {
            if(debugEnabled) console.log('pageInit', page)
        },
        pageBeforeRemove: function (page) {
            if(debugEnabled) console.log('pageBeforeRemove', page)
        },
    }
}