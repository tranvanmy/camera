import { callApiFetchPosts, callApiAddPost } from '../api/adminPost'
import { callApiEditPost, callApiDeletePost, callApiShowPost } from '../api/adminPost'
import Helper from '../library/Helper'

export const POST_STATUS_SHOW = 'show'
export const POST_STATUS_HIDDEN = 'hidden'

const ADMIN_POST_FETCH = 'admin_post_fetch'
const ADMIN_POST_SET_POST = 'admin_post_set_post'

const state = {
    posts: [],
    edit: {
        post: {}
    }
}

const mutations = {
    [ADMIN_POST_FETCH](state, { posts }) {
        return state.posts = posts;
    },

    [ADMIN_POST_SET_POST](state, { post }) {
        return state.edit.post = post
    }
}

const actions = {
    async callFetchPosts({ commit }, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiFetchPosts(params);
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            return commit(ADMIN_POST_FETCH, { posts: response.data });
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callPostAdd({ commit }, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiAddPost(params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            vue.$store.dispatch('callFetchPosts', { vue })
            
            vue.$toaster.success(response.data.message);

            return vue.$router.push({ path: '/posts' })
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callPostShow( { commit }, { vue, id }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiShowPost(id)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })
        
        if (response.status == 200) {
            return commit(ADMIN_POST_SET_POST, { post: response.data })
        }

        vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));

        return vue.$router.push({ path: '/posts' })
    },

    async callPostEdit({ commit }, { vue, id, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiEditPost(id, params)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })
        
        if (response.status == 200) {
            vue.$store.dispatch('callFetchPosts', { vue })

            vue.$toaster.success(response.data.message)
            
            return vue.$router.push({ path: '/posts' })
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async callPostDelete({ commit }, { vue, id }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })
        let response = await callApiDeletePost(id)
        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            vue.$store.dispatch('callFetchPosts', { vue })

            return vue.$toaster.success(response.data.message);
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    }
}

const storeAdminPost = {
    state,
    actions,
    mutations
}

export default storeAdminPost;
