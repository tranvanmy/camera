import { callApiFetchBanners, callApiAddBanner } from '../api/adminBanner'
import { callApiEditBanner, callApiDeleteBanner } from '../api/adminBanner'
import Helper from '../library/Helper'

export const BANNER_POSITION_SLIDER = 'banner'
export const BANNER_POSITION_AD = 'ad'
export const BANNER_POSITION_PARTNER = 'partner';

export const BANNER_STATUS_SHOW = true
export const BANNER_STATUS_HIDDEN = false


export const ADMIN_BANNER_POSITION_OPTION = [
    { value: BANNER_POSITION_SLIDER, text: 'textPositionSlider' },
    { value: BANNER_POSITION_AD, text: 'textPositionAd' },
    { value: BANNER_POSITION_PARTNER, text: 'textPositionPartner' },
]

const ADMIN_BANNER_FETCH = 'admin_banner_fetch'
const ADMIN_BANNER_MODAL_ADD = 'admin_banner_modal_add'
const ADMIN_BANNER_MODAL_EDIT = 'admin_banner_modal_edit'
const ADMIN_BANNER_CHANGE_TAB = 'admin_banner_change_tab'

const state = {
    banners: [],
    modalAdd: {
        open: false
    },
    modalEdit: {
        open: false,
        formData: {}
    },
    currentTab: ADMIN_BANNER_POSITION_OPTION[0].value,
}

const mutations = {
    [ADMIN_BANNER_FETCH](state, { banners }) {
        return state.banners = banners;
    },

    [ADMIN_BANNER_MODAL_ADD](state, { modalAdd }) {
        return state.modalAdd = modalAdd;
    },

    [ADMIN_BANNER_MODAL_EDIT](state, { modalEdit }) {
        return state.modalEdit = modalEdit;
    },

    [ADMIN_BANNER_CHANGE_TAB](state, { value }) {
        return state.currentTab = value
    },
}

const actions = {
    async callFetchBanners({ commit }, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiFetchBanners(params);
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            let banners = response.data.map((banner) => {
                return { 
                    ...banner, 
                    status: banner.status ? true: false
                }
            })

            return commit(ADMIN_BANNER_FETCH, { banners });
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callBannerAdd({ commit }, { vue, params }) {
        let modalAdd = vue.$store.state.storeAdminBanner.modalAdd

        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiAddBanner(params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            commit(ADMIN_BANNER_MODAL_ADD, { modalAdd: { ...modalAdd, open:false } })
            vue.$store.dispatch('callFetchBanners', { vue })

            return vue.$toaster.success(response.data.message);
        }

        commit(ADMIN_BANNER_MODAL_ADD, { modalAdd: { ...modalAdd, open:true } })

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    setBannerModalAdd({ commit }, { modalAdd }) {
        return commit(ADMIN_BANNER_MODAL_ADD, { modalAdd })
    },

    async callBannerEdit({ commit }, { vue, id, params }) {
        let modalEdit = vue.$store.state.storeAdminBanner.modalEdit

        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiEditBanner(id, params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            commit(ADMIN_BANNER_MODAL_EDIT, { modalEdit: { ...modalEdit, open:false } })
            vue.$store.dispatch('callFetchBanners', { vue })

            return vue.$toaster.success(response.data.message);
        }

        commit(ADMIN_BANNER_MODAL_EDIT, { modalEdit: { ...modalEdit, open:true } })

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    setBannerModalEdit({ commit }, { modalEdit }) {
        return commit(ADMIN_BANNER_MODAL_EDIT, { modalEdit})
    },

    async callBannerDelete({ commit }, { vue, id }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiDeleteBanner(id)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            vue.$store.dispatch('callFetchBanners', { vue })

            return vue.$toaster.success(response.data.message);
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    actionBannerChangeTab({ commit }, value) {
        return commit(ADMIN_BANNER_CHANGE_TAB, { value })
    },
}

const storeAdminBanner = {
    state,
    actions,
    mutations
}

export default storeAdminBanner;
