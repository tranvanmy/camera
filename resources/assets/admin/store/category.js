import { callApiFetchCategories, callApiAddCategory } from '../api/adminCategory'
import { callApiEditCategory, callApiDeleteCategory } from '../api/adminCategory'
import Helper from '../library/Helper'

export const CATEGORY_TYPE_PRODUCT = 'product'
export const CATEGORY_TYPE_POST = 'post'

export const CATEGORY_STATUS_SHOW = 'show'
export const CATEGORY_STATUS_HIDDEN = 'hidden'


export const ADMIN_CATEGORY_TYPE_OPTION = [
    { value: CATEGORY_TYPE_PRODUCT, text: 'textTypeProduct' },
    { value: CATEGORY_TYPE_POST, text: 'textTypePost' }
]

const ADMIN_CATEGORY_FETCH = 'admin_category_fetch'
const ADMIN_CATEGORY_MODAL_ADD = 'admin_category_modal_add'
const ADMIN_CATEGORY_MODAL_EDIT = 'admin_category_modal_edit'

const state = {
    categories: [],
    modalAdd: {
        open: false
    },
    modalEdit: {
        open: false,
        formData: {}
    }
}

const mutations = {
    [ADMIN_CATEGORY_FETCH](state, { categories }) {
        return state.categories = categories;
    },

    [ADMIN_CATEGORY_MODAL_ADD](state, { modalAdd }) {
        return state.modalAdd = modalAdd;
    },

    [ADMIN_CATEGORY_MODAL_EDIT](state, { modalEdit }) {
        return state.modalEdit = modalEdit;
    }
}

const actions = {
    async callFetchCategories({ commit }, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiFetchCategories(params);
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            return commit(ADMIN_CATEGORY_FETCH, { categories: response.data });
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callCategoryAdd({ commit }, { vue, params }) {
        let modalAdd = vue.$store.state.storeAdminCategory.modalAdd

        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiAddCategory(params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            commit(ADMIN_CATEGORY_MODAL_ADD, { modalAdd: { ...modalAdd, open:false } })
            vue.$store.dispatch('callFetchCategories', { vue })

            return vue.$toaster.success(response.data.message);
        }

        commit(ADMIN_CATEGORY_MODAL_ADD, { modalAdd: { ...modalAdd, open:true } })

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    setCategoryModalAdd({ commit }, { modalAdd }) {
        return commit(ADMIN_CATEGORY_MODAL_ADD, { modalAdd })
    },

    async callCategoryEdit({ commit }, { vue, id, params }) {
        let modalEdit = vue.$store.state.storeAdminCategory.modalEdit

        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiEditCategory(id, params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            commit(ADMIN_CATEGORY_MODAL_EDIT, { modalEdit: { ...modalEdit, open:false } })
            vue.$store.dispatch('callFetchCategories', { vue })

            return vue.$toaster.success(response.data.message);
        }

        commit(ADMIN_CATEGORY_MODAL_EDIT, { modalEdit: { ...modalEdit, open:true } })

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    setCategoryModalEdit({ commit }, { modalEdit }) {
        return commit(ADMIN_CATEGORY_MODAL_EDIT, { modalEdit})
    },

    async callCategoryDelete({ commit }, { vue, id }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiDeleteCategory(id)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            vue.$store.dispatch('callFetchCategories', { vue })

            return vue.$toaster.success(response.data.message);
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    }
}

const storeAdminCategory = {
    state,
    actions,
    mutations
}

export default storeAdminCategory;
