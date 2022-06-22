"user strict"
const storage = window.localStorage

const load = (e, callback) => {
    eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('2 a=1.4(\'5\');a.6=e;a.7=8;1.3(\'9\')[0].c(a);a.d(\'f\',g);a=h;b(e);',18,18,'|document|var|getElementsByTagName|createElement|script|src|defer|true|body||unload|append|addEventListener||load|callback|null'.split('|'),0,{}))
}

const unload = (e) => {
    eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('5 a=h.g(\'f\');d(5 2=a.b;2>=0;2--){9(a[2]&&a[2].6(\'4\')!=3&&a[2].6(\'4\').7(e)!=-1)a[2].8.c(a[2])}a=3;',18,18,'||i|null|src|var|getAttribute|indexOf|parentNode|if||length|removeChild|for||script|getElementsByTagName|document'.split('|'),0,{}))
}

load('js/framework7-bundle.min.js', () => {
    load('js/viewModel.js', () => {
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