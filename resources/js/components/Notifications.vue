<template>
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger badge-counter">{{notifications.length}}+</span>
        </a>
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                {{ title }}
            </h6>
            <li class="dropdown-item d-flex align-items-center" v-for="notification in notifications" :key="notification.id">                
                <div class="mr-3">
                    <a href="javascript:void(0)" :title="asRead" @click.prevent="markAsRead(notification.id)">
                        <div class="icon-circle bg-primary">
                            <i class="fab fa-readme text-white"></i>
                        </div>
                    </a>
                </div>
                <div>
                    <div class="small text-gray-500">{{ notification.created_at }}</div>
                    <span class="font-weight-bold" v-if="notification.data.project">{{ notification.data.message }}</span>

                    <span class="font-weight-bold" v-if="notification.data.task">
                        <a :href="'/tasks/show/' + notification.data.task.id">
                            {{ notification.data.message }}
                        </a>
                    </span>

                    <span class="font-weight-bold" v-if="notification.data.comment">
                        <a :href="'/tasks/show/' + notification.data.comment.task_id">
                            {{ notification.data.message }}
                        </a>
                    </span>
                </div>
            </li>
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
</script>
