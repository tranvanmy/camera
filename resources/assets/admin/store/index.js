import Vue from 'vue'
import Vuex from 'vuex'

import storeAuth from './auth'
import storeAdminMenu from './menus'
import storeLoading from './loading'
import storeAdminCategory from './category'
import storeAdminProduct from './product'
import storeAdminPost from './post'
import storeAdminBanner from './banner'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        storeAuth,
        storeAdminMenu,
        storeLoading,
        storeAdminCategory,
        storeAdminProduct,
        storeAdminPost,
        storeAdminBanner,
    }
})
