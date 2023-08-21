import { createStore } from 'vuex';
import axiosClient from './axios.js';

const store = createStore({
	state: {
    user: {
    	data: {},
    	token: sessionStorage.getItem("TOKEN"),
      admin: null
    },
    roles: {
      loading: false,
      data: []
    },
    currentRole : {
      data: {}
    },
    users: {
      loading: false,
      data: []
    },
    currentUser : {
      data: {}
    },
    roleTypes: [],
    expenseCategories: {
      loading: false,
      data: []
    },
    currentExpenseCategory : {
      data: {}
    },
    expenses: {
      loading: false,
      data: []
    },
    currentExpense : {
      data: {}
    },
    expenseCategoryTypes: [],
    sidebar: {}
	},
	actions: {
    // Profile
    saveProfile({commit}, user) {
      return axiosClient
        .post(`/user/${user.user_id}`, user.data)
        .then((res) => {
          // commit("setUser", res.data);
          return res;
        });
    },
    // Expense
    getExpenseCategoryTypes({commit}) {
      return axiosClient.get('/expense-category-types').then(({data}) => {
        commit("setExpenseCategoryTypes", data);
        return data;
      });
    },
    deleteExpense({commit}, data) {
      return axiosClient.delete(`/expense/${data.id}`, { params: { user_id: data.user_id } })
      .then(({data}) => {
        commit("setExpenses", data);
         return data;
      });
    },
    getExpense({commit}, expense) {
      commit("setCurrentExpense", expense);
    },
    getExpenses({commit}, id) {
      commit("setExpensesLoading", true);
      return axiosClient.get('/expense', { params: {user_id: id } })
      .then((res) => {
        commit("setExpensesLoading", false);
        commit("setExpenses", res.data);
        return res;
      });
    },
    saveExpense({commit}, expense) {
      let response;
      if(expense.id){
        response = axiosClient
          .put(`/expense/${expense.id}`, expense)
          .then((res) => {
            commit("setExpenses", res.data);
             return res;
          });
      } else {
        response = axiosClient.post("/expense", expense).then((res) => {
          commit("setExpenses", res.data);
          return res;
        });
      }
      return response;
    },
    // Expense Categories
    deleteExpenseCategory({commit}, id) {
      return axiosClient.delete(`/expense-category/${id}`)
      .then(({data}) => {
        commit("setExpenseCategories", data);
         return data;
      });
    },
    getExpenseCategory({commit}, expenseCategory) {
      commit("setCurrentExpenseCategory", expenseCategory);
    },
    getExpenseCategories({commit}) {
      commit("setExpenseCategoryLoading", true);
      return axiosClient.get('/expense-category').then((res) => {
        commit("setExpenseCategoryLoading", false);
        commit("setExpenseCategories", res.data);
        return res;
      });
    },
    saveExpenseCategory({commit}, expenseCategory) {
      let response;
      if(expenseCategory.id){
        response = axiosClient
          .put(`/expense-category/${expenseCategory.id}`, expenseCategory)
          .then((res) => {
            commit("setExpenseCategories", res.data);
             return res;
          });
      } else {
        response = axiosClient.post("/expense-category", expenseCategory).then((res) => {
          commit("setExpenseCategories", res.data);
          return res;
        });
      }
      return response;
    },
    // Users
    getRoleTypes({commit}) {
      return axiosClient.get('/role-types').then(({data}) => {
        commit("setRoleTypes", data);
        return data;
      });
    },
    deleteUser({commit}, id) {
      return axiosClient.delete(`/user/${id}`)
      .then(({data}) => {
        commit("setUsers", data);
         return data;
      });
    },
    getUser({commit}, user) {
      commit("setCurrentUser", user);
    },
    getUsers({commit}) {
      commit("setUsersLoading", true);
      return axiosClient.get('/user').then((res) => {
        commit("setUsersLoading", false);
        commit("setUsers", res.data);
        return res;
      });
    },
    saveUser({commit}, user) {
      let response;
      if(user.id){
        response = axiosClient
          .put(`/user/${user.id}`, user)
          .then((res) => {
            commit("setUsers", res.data);
             return res;
          });
      } else {
        response = axiosClient.post("/user", user).then((res) => {
          commit("setUsers", res.data);
          return res;
        });
      }
      return response;
    },
    // Roles
    deleteRole({commit}, id) {
      return axiosClient.delete(`/role/${id}`)
      .then(({data}) => {
        commit("setRoles", data);
         return data;
      });
    },
    getRole({commit}, role) {
      commit("setCurrentRole", role);
    },
    getRoles({commit}) {
      commit("setRolesLoading", true);
      return axiosClient.get('/role').then((res) => {
        commit("setRolesLoading", false);
        commit("setRoles", res.data);
        return res;
      });
    },
		saveRole({commit}, role) {
      let response;
      if(role.id){
        response = axiosClient
          .put(`/role/${role.id}`, role)
          .then((res) => {
            commit("setRoles", res.data);
             return res;
          });
      } else {
        response = axiosClient.post("/role", role).then((res) => {
          commit("setRoles", res.data);
          return res;
        });
      }
      return response;
    },
    // Auth
    register({commit}, user) {
      return axiosClient.post('/register', user)
        .then(({data}) => {
          commit('setUser', data);
          return data; 
        });
    },
		login({commit}, user) {
      return axiosClient.post('/login', user)
        .then(({data}) => {
          commit('setUser', data);
          return data; 
        });
    },
    logout({commit}) {
      return axiosClient.post('/logout')
        .then(response => {
          commit('logout');
          return response;
        });
    }
	},
	mutations: {
    // Users
    setExpenseCategoryTypes: (state, expCatTypes) => {
      state.expenseCategoryTypes = expCatTypes.data;
    },
    setCurrentExpense: (state, expense) => {
      state.currentExpense.data = expense;
    },
    setExpensesLoading: (state, loading) => {
      state.expenses.loading = loading;
    },
    setExpenses: (state, expenses) => {
      state.expenses.data = expenses.data;
    },
    // Expense Category
    setCurrentExpenseCategory: (state, expenseCategory) => {
      state.currentExpenseCategory.data = expenseCategory;
    },
    setExpenseCategoryLoading: (state, loading) => {
      state.expenseCategories.loading = loading;
    },
    setExpenseCategories: (state, expenseCategories) => {
      state.expenseCategories.data = expenseCategories.data;
    },
    // Users
    setRoleTypes: (state, roleTypes) => {
      state.roleTypes = roleTypes.data;
    },
    setCurrentUser: (state, user) => {
      state.currentUser.data = user;
    },
    setUsersLoading: (state, loading) => {
      state.users.loading = loading;
    },
    setUsers: (state, users) => {
      state.users.data = users.data;
    },
    // Roles
    setCurrentRole: (state, role) => {
      state.currentRole.data = role;
    },
    setRolesLoading: (state, loading) => {
      state.roles.loading = loading;
    },
    setRoles: (state, roles) => {
      state.roles.data = roles.data;
    },
    // Auth
		setUser: (state, userData) => {
      state.user.token = userData.token;
      state.user.data = userData.user;

      const auth_data = JSON.stringify(userData.user);
      sessionStorage.setItem('AUTH_USER', auth_data);
      sessionStorage.setItem('TOKEN', userData.token);
    },
    setAdminData: (state, data) => {
      state.user.admin = data;
    },
    setSidebar: (state, sidebar) => {
      state.sidebar = sidebar;
    },
	  logout: (state) => {
      state.user.token = null;
      state.user.data = {};
      sessionStorage.clear();
    },
	},
	getters: {

	}
});

export default store;