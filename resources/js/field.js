Nova.booting((Vue, router) => {
    Vue.component('index-help', require('./components/IndexField'));
    Vue.component('detail-help', require('./components/DetailField'));
    Vue.component('form-help', require('./components/FormField'));
})
