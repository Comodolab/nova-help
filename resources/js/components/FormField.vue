<template>
    <field-wrapper>
        <div class="comodolab-help-field-container w-full">
            <div :class="shownOnDetails?'w-1/4 py-6':'w-1/5 py-6 px-8'" v-if="field.sideLabel">
                <label class="inline-block text-80 leading-tight">
                    {{ field.name }}
                </label>
            </div>
            <div class="py-6 px-8 w-full" :class="fieldClasses">
                <div class="flex comodolab-help-field">
                    <div class="pr-4 comodolab-help-field-icon-container" v-html="field.icon" v-if="field.icon"></div>
                    <div>
                        <h4 v-if="!field.sideLabel && field.name" :class="{'mb-2':field.message}">{{field.name}}</h4>
                        <div :class="messageClasses">
                            <div v-if="field.asHtml" v-html="field.message"></div>
                            <div v-else>{{field.message}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </field-wrapper>
</template>

<script>
    import {FormField} from 'laravel-nova'

    export default {
        mixins: [FormField],

        props: ['resourceName', 'resourceId', 'field', 'context'],

        methods: {
            fill(formData) {
                // Do nothing...
            },
        },

        computed: {
            fieldClasses() {
                let fieldTypes = {
                    info: 'bg-info text-white',
                    warning: 'bg-warning text-warning-dark',
                    danger: 'bg-danger text-white',
                    header: 'bg-30'
                };
                return fieldTypes[this.field.type] || '';
            },
            messageClasses() {
                let fieldTypes = {
                    header: 'text-70'
                };
                return fieldTypes[this.field.type] || '';
            },
            shownOnDetails() {
                return this.context === 'details';
            }
        },
    }
</script>

<style lang="scss">
    .card {
        > div:nth-child(1) .comodolab-help-field-container {
            border-radius: .5rem .5rem 0 0;
            overflow: hidden
        }
        > div:last-child .comodolab-help-field-container {
            border-radius: 0 0 .5rem .5rem ;
            overflow: hidden
        }
    }
</style>
