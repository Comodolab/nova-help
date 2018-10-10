<template>
    <div>
        <div class="comodolab-help-field-icon-container inline-block"
             :class="iconClass"
             :data-balloon="field.message.replace(/<(?:.|\n)*?>/gm, '')"
             v-html="field.icon" v-if="field.icon && field.message"></div>
    </div>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],

        computed: {
            iconClass() {
                let fieldTypes = {
                    info: 'text-info',
                    warning: 'text-warning-dark',
                    danger: 'text-danger',
                };
                return fieldTypes[this.field.type] || '';
            },
        }
    }
</script>