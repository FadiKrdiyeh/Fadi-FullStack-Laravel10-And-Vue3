// import Vue from 'vue';
import Vuex from 'vuex';

// Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    // token: '',
    authUser: null,
    loadingStates: {
      loadingState: false,
      createLoadingState: false,
      editLoadingState: false,
      deleteLoadingState: false
    },
    deleteModalInfo: {
      showDeleteModal: false,
      deleteIndex: -1,
      deleteUrl: '',
      deleteData: null,
      isDeleted: false
    }
  },
  getters: {
    // getLoadingState (state) {
    //   return state.loadingState;
    // },
    getAuthUser (state) {
      return state.authUser;
    },
    getLoadingState: (state) => (type) => {
      return state.loadingStates[type];
    },
    getToken (state) {
      return state.token;
    },
    getDeleteModalInfo (state) {
      return state.deleteModalInfo;
    }
  },
  mutations: {
    setAuthUser (state, payload) {
      state.authUser = payload;
    },
    setLoadingState (state, payload) {
      state.loadingStates[payload.type] = payload.value;
    },
    setToken (state, payload) {
      state.token = payload;
    },
    setDeleteModalInfo (state, payload) {
      state.deleteModalInfo = payload;
    },
  },
  actions: {
    setAuthUserAction ({commit}, payload) {
      commit('setAuthUser', payload);
    },
    setLoadingStateAction ({commit}, payload) {
      commit('setLoadingState', payload);
    },
    setTokenAction ({commit}, payload) {
      commit('setToken', payload);
    },
    setDeleteModalInfoAction ({commit}, payload) {
      commit('setDeleteModalInfo', payload);
    },
  }
});
