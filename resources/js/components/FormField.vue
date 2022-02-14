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
                            <h4 v-if="field.asHtml" v-html="field.name" @click="toggle"></h4>
                            <h4 v-else :class="{'mb-2':field.message && !collapsed, 'clickable':field.collapsible}"
                                @click="toggle">
                                {{field.name}}
                                <div class="collapsible-caret"
                                     v-if="field.message && field.collapsible"
                                     :class="collapsed?'closed':'open'"></div>
                            </h4>
                        </template>
                        <div :class="messageClasses" v-if="displayMessage">
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

        data() {
            return {
                collapsed: this.field.collapsible
            }
        },

        methods: {
            fill(formData) {
                // Do nothing...
            },
            toggle(){
                if (!this.field.collapsible){
                    return;
                }
                this.collapsed = !this.collapsed;
            }
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

                let fieldTypes = this.field.typeClasses;
                fieldTypes.header = 'bg-30';

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
            },
            displayMessage(){
                return !this.collapsed || !this.field.collapsible || !this.field.name || this.field.sideLabel
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
    .collapsible-caret {
        display: inline-block;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        margin-bottom: 2px;
        margin-left: 5px;
        &.closed {
            border-top: 5px solid rgba(0,0,0,0.2);
        }
        &.open {
            border-bottom: 5px solid rgba(0,0,0,0.2);
        }
    }
    .clickable {
        cursor: pointer;
    }
</style>
