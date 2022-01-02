<template>

    <div>
        <div v-if="complete_form" >
        <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li class="errors" v-for="i in errors" >
                                {{i}}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="name" placeholder="Full Name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email"class="form-control" v-model="email" placeholder="E-mail">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" v-mask="'##-###-###-##-##'" class="form-control" v-model="phone" placeholder="Phone">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="date" :min="min_date" @change="selectDate" v-model="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="select-time-ul">
                            <li v-for="item in workingHours" class="select-time">
                                <input v-if="item.is_active" type="radio" v-model="workingHour" v-bind:value="item.id">
                                <span>{{item.hours}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea v-model="text" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">SMS</label>
                                        <input type="radio" v-model="notification_type" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="radio" v-model="notification_type" value="1">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button v-on:click="store" class="btn btn-success"> Randevu Oluştur</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!complete_form" >
            <div class="complete-form">
                <i class="bi bi-caret-right"></i>
                <span>Your appointment created successfully.</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            errors:[],
            complete_form:true,
            notification_type:null,
            workingHour:0,
            name:null,
            email:null,
            phone:null,
            text:null,
            min_date:new Date().toISOString().slice(0.10),
            date:new Date().toISOString().slice(0,10),
            workingHours:[]
        }
    },
    mounted() {
        axios.get('http://127.0.0.1:8000/api/working_hours').then((response)=>{
           this.workingHours = response.data;
            })
    },
    methods:{
 store:function () {
     if(this.name && this.email && this.validEmail(this.email) && this.phone && this.workingHour != 0 && this.notification_type){

        axios.post('http://127.0.0.1:8000/api/appointment_store',{
           fullName:this.name,
            phone:this.phone,
            email:this.email,
            date:this.date,
            hour:this.workingHour,
            description:this.text,
            notification_type:this.notification_type
        }).then((response) => {
            if(response.status){
                this.complete_form=false;
            }
        })
    }
     this.errors = [];

    if(!this.notification_type){
        this.errors.push("You should choose notification type.");
    }
    if(!this.name){
        this.errors.push("You should enter the name and surname.");
    }
     if(!this.email || !this.validEmail(this.email)){
         this.errors.push("The email must not be blank and must be in the correct format.");
     }
     if(!this.phone){
         this.errors.push("You should enter the phone.");
     }
     if(!this.workingHour){
         this.errors.push("You should choose the working hour.");
     }
 },
 selectDate:function (){
     axios.get('http://127.0.0.1:8000/api/working_hours/${this.date}').then((response)=>{
         this.workingHours = response.data;
     })
 },
        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
}
</script>
