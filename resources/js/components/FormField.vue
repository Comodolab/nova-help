<template>
    <field-wrapper>
        <div class="comodolab-help-field-container flex w-full">
            <div :class="labelClasses" v-if="field.sideLabel">
                <label class="inline-block text-80 leading-tight">
                    <span v-if="field.asHtml" v-html="field.name"></span>
                    <span v-else>{{ field.name }}</span>
                </label>
            </div>
            <div class="px-8" :class="fieldClasses">
                <div class="flex comodolab-help-field">
                    <div class="pr-4 comodolab-help-field-icon-container" v-html="field.icon" v-if="field.icon"></div>
                    <div>
                        <template v-if="!field.sideLabel && field.name">
                            <h4 v-if="field.asHtml" v-html="field.name"></h4>
                            <h4 v-else :class="{'mb-2':field.message}">{{field.name}}</h4>
                        </template>
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
            labelClasses() {
                let labelClasses = '';

                labelClasses = this.shownOnDetails ? ' w-1/4 py-4' : ' w-1/5 px-8 py-6';

                if (this.field.fullWidthOnDetail) {
                    labelClasses += ' px-6';
                }

                return labelClasses;
            },
            fieldClasses() {
                let fieldClasses = '';

                let fieldTypes = {
                    info: 'bg-info text-white',
                    warning: 'bg-warning text-warning-dark',
                    danger: 'bg-danger text-white',
                    header: 'bg-30'
                };

                fieldClasses = fieldTypes[this.field.type] || '';

                if (!this.field.sideLabel) {
                    fieldClasses += ' w-full';
                }

                fieldClasses += this.shownOnDetails ? ' w-3/4 py-4' : ' w-4/5 py-6';

                return fieldClasses;
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
            border-radius: 0 0 .5rem .5rem;
            overflow: hidden
        }
    }
</style>
