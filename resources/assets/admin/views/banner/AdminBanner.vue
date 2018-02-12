<template>
    <b-row>
        <AdminBannerAdd
            :submitModalAdd='submitModalAdd'
            :modalAdd="modalAdd"
            :hideModalAdd="hideModalAdd"
            
        />
        <AdminBannerEdit
            :submitModalEdit='submitModalEdit'
            :modalEdit.sync="modalEdit"
            :hideModalEdit="hideModalEdit"
        />
        <b-col lg="12">
            <b-button-group class="pull-right">
                <b-button variant="success" @click="clickAddNewItem">
                    <i class="icon-plus"></i>
                    {{ $t('textAddBanner') }}
                </b-button>
            </b-button-group>
        </b-col>
        <b-col lg="12">
            <b-tabs pills card>
                <b-tab
                    :title="$t(option.text)"
                    v-for="option in optionPosition"
                    :key="option.value"
                >
                    <b-table
                        :hover="hover" :striped="striped"
                        :bordered="bordered" :small="small"
                        :fixed="fixed" class="table-responsive-sm"
                        :items="getItemFilter(option.value)"
                        :fields="fields"
                        :current-page="currentPage"
                        :per-page="perPage"
                    >
                        <template slot="status" slot-scope="data">
                            <b-button size="sm" :variant="data.item.status == 'show' ? 'success' : 'danger'">
                                {{ $t(data.item.status) }}
                            </b-button>
                        </template>
                        <template slot="image" slot-scope="data">
                            <b-img thumbnail 
                                :src="`/${data.item.image}`" 
                                :alt="data.item.name"
                                style="width: 150px"
                                v-if="data.item.image"
                            />
                        </template>
                        <template slot="position" slot-scope="data">
                            {{ getTextPosition(data) }}
                        </template>
                        <template slot="action" slot-scope="data">
                            <b-button
                                type="submit" size="sm"
                                variant="primary"
                                @click="clickEditMenu(data.item)"
                            >
                                <i class="icon-pencil"></i>
                                {{ $t('textEdit') }}
                            </b-button>
                            <b-button
                                type="reset" size="sm"
                                variant="danger"
                                @click="clickDeleteMenu(data.item.id)"
                            >
                                <i class="icon-trash"></i>
                                {{ $t('textDelete') }}
                            </b-button>
                        </template>
                    </b-table>
                </b-tab>
            </b-tabs>
        </b-col>
    </b-row>
</template>

<script>
    import AdminBannerAdd from './AdminBannerAdd.vue'
    import AdminBannerEdit from './AdminBannerEdit.vue'

    import { ADMIN_BANNER_POSITION_OPTION } from '../../store/banner'
    import { BANNER_STATUS_SHOW, BANNER_STATUS_HIDDEN } from '../../store/banner'
    import Helper from '../../library/Helper'

    export default {
        name: 'AdminMenu',
        components: { AdminBannerAdd, AdminBannerEdit },
        props: {
            hover: {
                type: Boolean,
                default: false
            },
            striped: {
                type: Boolean,
                default: false
            },
            bordered: {
                type: Boolean,
                default: false
            },
            small: {
                type: Boolean,
                default: false
            },
            fixed: {
                type: Boolean,
                default: false
            },
        },

        beforeCreate() {
            Helper.changeTitleAdminPage(this.$i18n.t('textManageBanner'))
            this.$store.dispatch('callFetchBanners', { vue: this })
        },

        data() {
            return {
                fields: [
                    {key: 'name', label: this.$i18n.t('textName')},
                    {key: 'link', label: this.$i18n.t('textLink')},
                    {key: 'image', label: this.$i18n.t('textImage')},
                    {key: 'status', label: this.$i18n.t('textStatus')},
                    {key: 'action', label: this.$i18n.t('textAction')},
                ],
                currentPage: 1,
                perPage: this.totalRows,
                optionPosition: ADMIN_BANNER_POSITION_OPTION
            }
        },

        methods: {
            getTextPosition(item) {
                let index = _.findIndex(ADMIN_BANNER_POSITION_OPTION, (option) => option.value === item.item.position)

                return this.$i18n.t(ADMIN_BANNER_POSITION_OPTION[index].text)
            },

            filterData(item) {
                let result = {}
                let fields = this.fields
                for(let i = 0; i < fields.length; i++) {
                    result[fields[i].key] = item[fields[i].key]
                }

                return result;
            },

            getItemFilter(position) {
                return this.items.filter(item => item.position == position)
            },

            clickAddNewItem() {
                let modalAdd = { ...this.modalAdd, open: true }

                return this.$store.dispatch('setBannerModalAdd', { vue: this, modalAdd })
            },

            convertDataSubmit(params) {
                return {
                    ...params,
                    status: params.status ? BANNER_STATUS_SHOW : BANNER_STATUS_HIDDEN
                }
            },

            submitModalAdd(params) {
                return this.$store.dispatch('callBannerAdd', { vue: this, params: this.convertDataSubmit(params) })
            },

            hideModalAdd(formData) {
                let modalAdd = { ...this.modalAdd, open: false }

                return this.$store.dispatch('setBannerModalAdd', { vue: this, modalAdd })
            },

            clickEditMenu(formData) {
                let modalEdit = { ...this.modalEdit, open: true, formData }

                return this.$store.dispatch('setBannerModalEdit', { vue: this, modalEdit })
            },

            submitModalEdit(id, params) {
                return this.$store.dispatch('callBannerEdit', { 
                    vue: this,
                    params: this.convertDataSubmit(params), 
                    id 
                })
            },

            hideModalEdit() {
                let modalEdit = { ...this.modalEdit, open: false };

                return this.$store.dispatch('setBannerModalEdit', { vue: this, modalEdit })
            },

            async clickDeleteMenu(id) {
                return id
                    && await this.$swal({
                        title: this.$i18n.t('textConfirmDelete'),
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    && this.$store.dispatch('callBannerDelete', { vue: this, id })
            }
        },

        computed: {
            loading() {
                return this.$store.state.storeLoading.loading
            },

            items() {
                return this.$store.state.storeAdminBanner.banners
            },

            modalAdd() {
                return this.$store.state.storeAdminBanner.modalAdd
            },

            modalEdit() {
                return this.$store.state.storeAdminBanner.modalEdit
            },

            totalRows() {
                return this.items.length
            }
        },
    }
</script>
