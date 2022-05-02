import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((Vue, router) => {
    Vue.component('index-help', IndexField);
    Vue.component('detail-help', DetailField);
    Vue.component('form-help', FormField);
})
