<template>
    <form-field :field="field" context="details" :class="{'help-field-full-width':field.fullWidthOnDetail}"></form-field>
</template>

<script>
    import FormField from './FormField'

    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],

        components: {FormField}
    }
</script>
