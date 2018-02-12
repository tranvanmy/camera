<template>
    <b-modal
        :title="$t('textAddCategory')"
        v-model="openModalValue"
        @ok="submitModalAdd"
        @hidden="hideModalAdd"
        :centered="true" size="lg"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="8">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input 
                                    type="text" required
                                    :placeholder="$t('textName')" 
                                    v-model="formData.name" 
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4" class="text-center">
                            <b-form-fieldset :label="$t('textStatus')">
                                <c-switch
                                    type="text" variant="primary-outline-alt"
                                    on="On" off="Off"
                                    :pill="true" :checked="true"
                                    v-model="formData.status"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="8">
                            <b-form-fieldset :label="$t('textSlug')">
                                <b-form-input 
                                    type="text" required
                                    :placeholder="$t('textSlug')" 
                                    v-model="formSlugName" 
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="number" :placeholder="$t('textPrioty')" v-model.number="formData.prioty" />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textParentCategory')">
                                <b-form-select
                                    :plain="true"
                                    :options="parentCategoryOption"
                                    v-model.number="formData.parent_id"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textType')">
                                <b-form-select
                                    :plain="true" required
                                    :options="optionTypeCategory"
                                    v-model="formData.type"
                                >
                                </b-form-select>
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-form-fieldset :label="$t('textDescription')">
                        <b-form-input
                            v-model="formData.description"
                            :placeholder="$t('textDescription')"
                        />
                    </b-form-fieldset>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textSeoKeyword')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textSeoKeyword')"
                                    v-model="formData.seo_keyword"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textSeoDescription')">
                                <b-form-input
                                    type="text"
                                    :placeholder="$t('textSeoDescription')"
                                    v-model="formData.seo_description"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
        <div slot="modal-footer" class="w-100 text-center">
            <b-button type="submit" size="xs" variant="primary" @click="clickAddItem">
                <i class="fa fa-dot-circle-o"></i>
                {{ $t('textAddNew') }}
            </b-button>
            <b-button type="reset" size="xs" variant="danger" @click="hideModalAdd">
                <i class="fa fa-ban"></i>
                {{ $t('textCancel') }}
            </b-button>
       </div>
    </b-modal>
</template>

<script>
import cSwitch from '../../../components/Switch.vue'

import { ADMIN_CATEGORY_TYPE_OPTION } from '../../store/category'

export default {
    name: 'AdminCategoryAdd',

    components: { cSwitch },

    props: {
        modalAdd: {
            type: Object,
            required: true
        },
        submitModalAdd: {
            type: Function,
            required: true
        },
        hideModalAdd: {
            type: Function,
            required: true
        },
        parentCategoryOption: {
            type:Array,
            required: true
        }
    },

    data() {
        return {
            optionTypeCategory: ADMIN_CATEGORY_TYPE_OPTION.map(option => (
                { value: option.value, text: this.$i18n.t(option.text) }
            )),
            formData: this.resetFromData()
        }
    },

    methods: {
        resetFromData() {
            return this.formData = {
                name: '',
                slug: '',
                status: true,
                prioty: 0,
                parent_id: '',
                type: ADMIN_CATEGORY_TYPE_OPTION[0].value,                
                description: '',
                seo_keyword: '',
                seo_description: '',
            }
        },

        clickAddItem() {
            let params = this.formData
            console.log(this.formData)
            if (!params.name || !params.slug || !params.type) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            this.resetFromData()

            return this.submitModalAdd(params)
        }
    },

    computed: {
        openModalValue: {
            get() {
                return this.modalAdd.open
            },
            set(val) {}
        },
        formSlugName: {
            get() {
                return slug(this.formData.name.toLowerCase())
            },
            set(val) {
                return this.formData.slug = val
            }
        }
    }
}
</script>
