<template>
  <div @click="Refocus" style="height: 100vh;">
    <v-text-field style="opacity: 0;" ref="user" v-model="user" autofocus @input="mSwipe" :disabled="this.user != null"></v-text-field>
    <v-simple-table style="margin-top: -40px;" class="text-center mx-2">
        <thead>
            <tr style="background-color: blue; color: white; font-weight: bold;">
                <td v-for="(head, i) in header" :key="i">{{ head }}</td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, k) in data" :key="k">
                <td v-for="(head, i) in header" :key="i">{{ item[head] }}</td>
            </tr>
        </tbody>
    </v-simple-table>
  </div>
</template>

<script>
export default {
    data: () => ({
        header: ['User', 'Date', 'Login', 'Logout', 'Total'],
        data:[],
        user: null
    }),
    props:{
        notificationSystem:{type:Object,required:true}
    },
    methods:{
        mSwipe(){
            const date = new Date();
            const formattedDate = date.toLocaleDateString('en-ZA');
            const time = date.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
                });
           
            let index = this.data.findIndex(rec => rec.User == this.user  && rec.Date == formattedDate)

            if(index == -1){
                this.data.push({User: this.user, Date: formattedDate, Login: time})
                this.$toast.success('User '+this.user+' logged in successfully!', 'OK', this.notificationSystem.options.error)
            }
                
            else{

                if(this.data[index].Logout == undefined){
                    this.data[index].Logout = time
                    const difference =  this.timeToMillis(time) - this.timeToMillis(this.data[index].Login)
                    this.data[index].Total = this.millisToTime(difference)
                    this.$toast.success('User '+this.user+' logged out successfully!', 'OK', this.notificationSystem.options.error)
                }
                else{
                    this.$toast.error('User '+this.user+' already logged out!', 'Error', this.notificationSystem.options.error)
                }
              
            }
            setTimeout(() => {
                
                this.user = null

                setTimeout(() => {
                    this.Refocus() 
                }, 1);
                
            }, 1);
            
        },

        timeToMillis(timeString) {
            const [hours, minutes, seconds] = timeString.split(':').map(Number);
            return (hours * 3600 + minutes * 60 + seconds) * 1000;
        },

        Refocus(){
            this.$refs.user.focus()
        },

        millisToTime(ms) {
            // Handle negative results
            const absoluteMs = Math.abs(ms);
            const h = Math.floor(absoluteMs / 3600000);
            const m = Math.floor((absoluteMs % 3600000) / 60000);
            const s = Math.floor((absoluteMs % 60000) / 1000);
            
            const pad = (n) => n.toString().padStart(2, '0');
            return `${ms < 0 ? '-' : ''}${pad(h)}:${pad(m)}:${pad(s)}`;
        }

    
    }
}
</script>

<style>

</style>