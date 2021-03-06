<template>
    <div class="input-group mb-3">
        <input type="text" class="form-control" v-model="text_time" style="width:10px" disabled>
        <div class="input-group-append">
            <button class="btn btn-success" v-if="!running" @click="startTimer"><i class="fa fa-play"></i></button>
            <button class="btn btn-danger" v-if="running" @click="pauseTimer"><i class="fa fa-pause"></i></button>
            <button class="btn btn-primary" @click="resetTimer"><i class="fa fa-sync"></i></button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: 'time-counter',
        props: ['totalWorked', 'task_id', 'project_id', 'msg_title', 'msg_message', 'msg_confirm', 'msg_cancel'],
        data() {
            return {
                time_running: localStorage.getItem(this.task_id + '_timer_running') == "true" ? true : false,
                total_worked: parseInt(this.totalWorked),
                time_elapsed: 0,
                total_time: localStorage.getItem(this.task_id + '_total_time') ? parseInt(localStorage.getItem(this.task_id + '_total_time')) : 0,
                text_time: "",
                timer: null,
            }
        },
        mounted() {
            if((this.total_worked + this.total_time) <= 0) {
                this.text_time = "00:00:00"
            }
            else {
                if (this.total_time > 0) {
                    this.total_worked = this.total_time
                }
                if (this.time_running) {
                    this.timer = setInterval(this.clockTick.bind(null, this.total_time), 1000)
                } else {
                    this.updateDisplay(this.total_worked)
                }
            }
        },
        computed: {
            running: function() {
                if (this.time_running) {
                    localStorage.setItem(this.task_id + '_timer_running', "true")
                    localStorage.setItem(this.task_id + '_total_time', this.total_time)
                    return true
                } else {
                    localStorage.setItem(this.task_id + '_timer_running', "false")
                    localStorage.setItem(this.task_id + '_total_time', this.total_time)
                    return false
                }
            }
        },
        methods: {
            startTimer: function() {
                this.timer = setInterval(this.clockTick, 1000)
                this.time_running = true;                

                this.sendTaskTime('start')
            },
            pauseTimer: function() {
                clearInterval(this.timer)
                this.sendTaskTime('pause')

                this.time_running = false;
            },
            clockTick: function() {
                this.total_time = ++this.time_elapsed + this.total_worked
                this.updateDisplay(this.total_time)                
            },
            updateDisplay: function(total_seconds) {
                let hours = Math.floor(total_seconds / 3600);
                let seconds_left = total_seconds - (hours * 3600);
                let minutes = Math.floor(seconds_left / 60);
                seconds_left = Math.floor(seconds_left - (minutes * 60))

                hours = hours > 9 ? hours : "0" + hours
                minutes = minutes > 9 ? minutes : "0" + minutes 
                seconds_left = seconds_left > 9 ? seconds_left : "0" + seconds_left

                this.text_time = hours + ":" + minutes + ":" + seconds_left
            },
            resetTimer: function() {
                swal.fire({
                title: this.msg_title,
                text: this.msg_message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: this.msg_cancel,
                confirmButtonText: this.msg_confirm
                }).then((result) => {
                    if (result.value) {
                        clearInterval(this.timer)
                        this.sendTaskTime('reset')

                        this.time_elapsed = 0
                        this.text_time= "00:00:00"
                        this.time_running = false;
                        this.total_time = 0
                        this.time_elapsed = 0
                        this.total_worked = 0

                        localStorage.removeItem(this.task_id + '_timer_running')
                        localStorage.removeItem(this.task_id + '_total_time')
                    }
                })
            },
            sendTaskTime: function(type) {                
                let data = {
                    'type': type,
                    'task_id': this.task_id,
                    'project_id': this.project_id
                }

                axios.post("/tasks/ajax-update-task-time", data).then(response => {
                    this.alert(response.data.msg, response.data.status)
                }).catch(error => {
                    this.alert(error.response.data.message, 'error')
                }) 
            },
            alert: function(title, icon) {
                toast.fire({
                    title: title,
                    icon: icon,
                    background: '#e7ffff',
                })
            },
        }
    }
</script>
