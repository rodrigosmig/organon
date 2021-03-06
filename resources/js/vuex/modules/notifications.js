export default {
    state: {
        items: []
    },

    mutations: {
        LOAD_NOTIFICATIONS (state, notifications) {
            state.items = notifications
        },
        MARK_AS_READ (state, id) {
            let index = state.items.filter(notification => notification.id == id)
            state.items.splice(index, 1)
        }
    },
    actions: {
        loadNotifications(context) {
            axios.get('/notifications')
                .then(response => {
                    context.commit('LOAD_NOTIFICATIONS', response.data.notifications)
                })
        },
        markAsRead(context, params) {
            axios.put('/notifications/read', params)
                .then(response => {
                    context.commit('MARK_AS_READ', params.id)
                })
        }
    }
}