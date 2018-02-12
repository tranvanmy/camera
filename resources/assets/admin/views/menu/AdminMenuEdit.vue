<template>
    <b-modal
        :title="$t('textEditMenu')"
        v-model="openModalValue"
        @ok="submitModalEdit"
        @hidden="hideModalEdit"
        :centered="true" size="lg"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input
                                    type="text" required
                                    :placeholder="$t('textName')"
                                    v-model.number="formData.name"
                                />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textLink')">
                                <b-form-input
                                    type="text" required
                                    :placeholder="$t('textLink')"
                                    v-model="formData.path"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="number" :placeholder="$t('textPrioty')" v-model.number="formData.prioty" />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-row v-show="openModalValue">
                        <b-col sm="12">
                            <b-form-fieldset :label="$t('textIcon')"
                                style="boder: 1px solid #E5E5E5"
                            >
                                <img :src="`/${formData.icon}`" 
                                    style="max-width: 120px; paddding: 10px; margin-bottom: 15px"
                                    v-if="formData.icon"
                                />

                                <vue-transmit
                                    tag="section"
                                    v-bind="uploadOptions"
                                    @success="successUploader"
                                    upload-area-classes="bg-faded"
                                    ref="uploader"
                                >
                                    <b-row>
                                        <b-col sm="2"
                                            style="border-radius: 1px; boder: 1px solid #DCDCDC"
                                            class="text-left"
                                        >
                                            <button class="btn btn-primary"
                                            @click="triggerBrowse"
                                        >{{ $t('textUploadNewFile') }}</button>
                                        </b-col>
                                    </b-row>
                                    <!-- Scoped slot -->
                                    <template slot="files" slot-scope="props">
                                        <div v-for="(file, i) in props.files" :key="file.id" :class="{'mt-5': i === 0}">
                                            <div class="media">
                                                <img :src="file.dataUrl" class="img-fluid d-flex mr-3">
                                                <div class="media-body">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success"
                                                            :style="{width: file.upload.progress + '%'}"
                                                        >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </vue-transmit>
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-form-fieldset :label="$t('textDescription')">
                        <b-form-input
                            v-model="formData.description"
                            :placeholder="$t('textDescription')"
                        >
                        </b-form-input>
                    </b-form-fieldset>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
        <div slot="modal-footer" class="w-100 text-center">
            <b-button type="submit" size="xs" variant="primary" @click="clickEditMenu">
                <i class="fa fa-dot-circle-o"></i>
                {{ $t('textSave') }}
            </b-button>
            <b-button type="reset" size="xs" variant="danger" @click="hideModalEdit">
                <i class="fa fa-ban"></i>
                {{ $t('textCancel') }}
            </b-button>
       </div>
    </b-modal>
</template>

<script>
import { STORAGE_AUTH } from '../../store/auth'

export default {
    name: 'AdminMenuEdit',

    props: {
        modalEdit: {
            type: Object,
            required: true
        },
        submitModalEdit: {
            type: Function,
            required: true
        },
        hideModalEdit: {
            type: Function,
            required: true
        },
    },

    data() {
        let token = JSON.parse(localStorage.getItem(STORAGE_AUTH)).token
        let today = new Date()

        return {
            uploadOptions: {
                acceptedFileTypes: ['image/*'],
                url: '/api/v0/upload-image',
                clickable: false,
                params: {
                    folder: `product-${today.getFullYear()}
                        -${today.getMonth() + 1}
                        -${today.getDate()}
                    `,
                },
                maxFiles: 1,                
                paramName: 'image',
                headers: {
                    Authorization: `${token.token_type} ${token.access_token}`
                }
            }
        }
    },

    methods: {
        triggerBrowse(event) {
            event.preventDefault()

            if (this.$refs.uploader.files.length >= this.uploadOptions.maxFiles) {
                return this.$toaster.error(this.$i18n.t('textNotAddFile'));
            }

            return this.$refs.uploader.triggerBrowseFiles()
        },

        successUploader(response) {
            let serveRespone = JSON.parse(response.xhr.response)
            
            return this.formData.icon = serveRespone.path
        },

        clickEditMenu() {
            let params = this.formData

            if (!params.name || !params.path) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            this.$refs.uploader.files = []

            return this.submitModalEdit(this.formData.id, params)
        },
    },

    computed: {
        openModalValue: {
            get() {
                return this.modalEdit.open
            },
            set(val) {
            }
        },
        formData() {
            return {...this.modalEdit.formData}
        },
    }
}
</script>
