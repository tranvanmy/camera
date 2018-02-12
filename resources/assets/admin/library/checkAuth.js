import router from '../router/router'

import { STORAGE_AUTH, PERMISSION_ADMIN } from '../store/auth'

let defaultAuth = JSON.stringify({ user: {}, token: {} })
let auth = JSON.parse(localStorage.getItem(STORAGE_AUTH) || defaultAuth);

if (auth && auth.token && auth.token.access_token) {
    axios.defaults.headers.common['Authorization'] = `${auth.token.token_type} ${auth.token.access_token}`;

    axios.get('/user')
    .then(response => {
        let user = response.data;

        if (!user || !user.is_active || !user.permission == PERMISSION_ADMIN) {
            localStorage.setItem(STORAGE_AUTH, defaultAuth)

            return router.push({ path: '/login' });
        }
    })
    .catch(error => {
        localStorage.setItem(STORAGE_AUTH, defaultAuth)

        return router.push({ path: '/login' });
    })
} else {
    localStorage.setItem(STORAGE_AUTH, defaultAuth)
}
