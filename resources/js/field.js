Nova.booting((Vue, router) => {
    Vue.component('index-help', require('./components/IndexField').default);
    Vue.component('detail-help', require('./components/DetailField').default);
    Vue.component('form-help', require('./components/FormField').default);
})
