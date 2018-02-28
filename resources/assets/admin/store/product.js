import { callApiFetchProducts, callApiAddProduct } from '../api/adminProduct'
import { callApiEditProduct, callApiDeleteProduct, callApiShowProduct } from '../api/adminProduct'
import Helper from '../library/Helper'

export const PRODUCT_STATUS_SHOW = 'show'
export const PRODUCT_STATUS_HIDDEN = 'hidden'

const ADMIN_PRODUCT_FETCH = 'admin_product_fetch'
const ADMIN_PRODUCT_SET_PAGE = 'admin_product_set_page'
const ADMIN_PRODUCT_SET_PRODUCT = 'admin_product_set_product'

const state = {
    products: [],
    edit: {
        product: {}
    },
    currentPage: 1
}

const mutations = {
    [ADMIN_PRODUCT_FETCH](state, { products }) {
        return state.products = products;
    },

    [ADMIN_PRODUCT_SET_PAGE](state, { page }) {
        return state.currentPage = page
    },

    [ADMIN_PRODUCT_SET_PRODUCT](state, { product }) {
        return state.edit.product = product
    },
}

const actions = {
    async callFetchProducts({ commit }, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiFetchProducts(params);
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            return commit(ADMIN_PRODUCT_FETCH, { products: response.data });
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    actionProductSetPage({ commit }, { page }) {
        return commit(ADMIN_PRODUCT_SET_PAGE, { page })
    },

    async callProductAdd({ commit }, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiAddProduct(params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })
        
        if (response.status == 200) {
            vue.$store.dispatch('callFetchProducts', { vue })
            
            vue.$toaster.success(response.data.message);

            return vue.$router.push({ path: '/products' })
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callProductShow( { commit }, { vue, id }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiShowProduct(id)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            return commit(ADMIN_PRODUCT_SET_PRODUCT, { product: response.data })
        }

        vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));

        return vue.$router.push({ path: '/products' })
    },

    async callProductEdit({ commit }, { vue, id, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiEditProduct(id, params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            vue.$store.dispatch('callFetchProducts', { vue })

            vue.$toaster.success(response.data.message)
            
            return vue.$router.push({ path: '/products' })
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callProductDelete({ commit }, { vue, id }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiDeleteProduct(id)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            vue.$store.dispatch('callFetchProducts', { vue })

            return vue.$toaster.success(response.data.message);
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    }
}

const storeAdminProduct = {
    state,
    actions,
    mutations
}

export default storeAdminProduct;
