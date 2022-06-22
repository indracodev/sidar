"user strict"
const storage = eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c+'\\b','g'),k[c])}}return p}('0.1',2,2,'window|localStorage'.split('|')))

const load = (e, callback) => {
    eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c.toString(a)+'\\b','g'),k[c])}}return p}('5 1=2.a(\'4\');1.c=e;1.b=9;2.3(\'7\')[0].8(1);1.h(\'k\',d);5 6=2.3(\'4\').j;5 i=0;f(i<6){2.3(\'4\')[0].g();i++}',21,21,'|scr|document|getElementsByTagName|script|let|len|body|append|true|createElement|defer|src|callback||while|remove|addEventListener||length|load'.split('|')))
}

load(`js/framework7-bundle.min.js?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`, () => {
    delete self.scrIndex
    delete self.Dom7
    load(`js/tom-select.min.js?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`, () => {
        load(`js/viewModel.js?v=${Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)}`, () => {
            new Framework7({
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
                }
            })
        })
    })
})