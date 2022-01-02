<template>
    <div class="row">
        <div v-for="item in data" class="col-md-4">
            <div class="card appointment-card">
                <span class="appointment-number">Appointment
                      <span class="new-appointment bg-yellow" v-if="item.is_active == 0" >New</span>
                    <span  class="new-appointment bg-green" v-if="item.is_active == 1" >Approved</span>
                    <span  class="new-appointment" v-if="item.is_active == 2" >Rejected</span>
                </span>
                <div class="appointment-detail">
                    <span>{{item.fullName}}</span>
                    <span>{{item.date}}</span>
                    <span>{{item.working}}</span>
                </div>
                <div class="appointment-buttons" v-if="!item.is_active" >
                    <button @click="appointmentApprove(item.id)" >Approve</button>
                    <button @click="appointmentReject(item.id)" >Reject</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props:['data'],
created() {
    console.log("adminlist");
},
methods:{
appointmentApprove:function (id){
    this.$emit('updateOkey',id);
},
appointmentReject:function (id){
    this.$emit('updateReject',id);
}
}
}
</script>

<style scoped>

</style>
