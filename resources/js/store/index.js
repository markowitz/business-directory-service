import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store({
    state: {
        userData: null,
        searchData: null
    },
    mutations: {
        setUser(state, payload) {
            state.userData = payload;
        },
        setSearchData(state, payload) {
            state.searchData = payload;
        }
    },
    actions: {
        setUser({commit}, data) {
            commit('setUser', data);
        },
        setSearchData({commit}, data) {
            commit('setSearchData', data);
        }
    }
})