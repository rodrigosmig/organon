<template>
    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">{{notifications.length}}+</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                {{ title }}
            </h6>
            <a class="dropdown-item d-flex align-items-center" href="#" @click.prevent="markAsRead(notification.id)" v-for="notification in notifications" :key="notification.id" :title="asRead">
                
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ notification.created_at }}</div>
                    <span class="font-weight-bold" v-if="notification.data.project">{{ notification.data.message }} {{ notification.data.project.name }}.</span>
                    <span class="font-weight-bold" v-if="notification.data.task"><U>{{ notification.data.task.name }}</u> : {{ notification.data.message }} {{ notification.data.user.name }}</span>
                </div>
            </a>

            <a class="dropdown-item d-flex align-items-center" href="#" v-if="notifications.length == 0">
                <span class="font-weight-bold" >{{ empty }}</span>
            </a>

            
            <a class="dropdown-item text-center small text-gray-500" href="/notifications/all">{{ footer }}</a>
        </div>
    </li>
</template>

<script>
    export default {
        props: ['title', 'footer', 'asRead', 'empty'],
        created() {
            this.$store.dispatch('loadNotifications')
        },
        computed: {
            notifications() {
                return this.$store.state.notifications.items
            }
        },
        methods: {
            markAsRead(idNotification) {
                this.$store.dispatch('markAsRead', {id: idNotification})
            }
        }
    }

    /* export default {
        props: ['title', 'footer'],
        created() {
            this.loadNotifications()
        },
        data() {
            return {
                notificationsItems: []
            }
        },
        computed: {
            notifications() {
                return this.notificationsItems
            }
        },
        methods: {
            loadNotifications() {
                axios.get('/notifications')
                    .then(response => {
                        console.log(response.data.notifications)
                        this.notificationsItems = response.data.notifications
                    })
            }
        }
    } */
</script>

