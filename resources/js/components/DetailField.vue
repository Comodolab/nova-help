<template>
    <form-field :field="field" context="details"
                class="help-field-on-details"
                :class="{'help-field-full-width':field.fullWidthOnDetail}"></form-field>
</template>

<script>
    import FormField from './FormField'

    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],

        components: {FormField}
    }
</script>

<style lang="scss">
    .help-field-on-details:not(.help-field-full-width) .comodolab-help-field-container {
        border-radius: 0 !important;
    }

    .card > div:nth-child(1).help-field-full-width {
        margin-top: -12px;
    }
</style>