<template>
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="waiting-tab" data-toggle="tab" href="#waiting" role="tab" aria-controls="waiting" aria-selected="true">Appointments pending confirmation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Today's appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Upcoming appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Past appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reject-tab" data-toggle="tab" href="#reject" role="tab" aria-controls="reject" aria-selected="false">Rejected appointments</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <appointment-item @updateOkey="updateOkey" :data="waiting.data" @updateReject="updateReject" ></appointment-item>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <pagination :data="waiting"  @pagination-change-page ="getData" ></pagination>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <appointment-item @updateOkey="updateOkey" :data="today.data" @updateReject="updateReject"  ></appointment-item>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <pagination :data="today"  @pagination-change-page ="getData" ></pagination>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <appointment-item @updateOkey="updateOkey" :data="list.data" @updateReject="updateReject" ></appointment-item>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <pagination :data="list"  @pagination-change-page ="getData" ></pagination>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <appointment-item @updateOkey="updateOkey" :data="last.data" @updateReject="updateReject" ></appointment-item>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <pagination :data="last"  @pagination-change-page ="getData" ></pagination>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="reject" role="tabpanel" aria-labelledby="reject-tab">
                <appointment-item @updateOkey="updateOkey" :data="reject.data" @updateReject="updateReject" ></appointment-item>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <pagination :data="reject"  @pagination-change-page ="getData" ></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data(){
        return{
            waiting:{
                data:[]
            },
            list:{
                data:[]
            },
            today:{
                data:[]
            },
            last:{
                data:[]
            },
            reject:{
                data:[]
            }
        }
    },
    created(){
console.log("hereeee");
        this.getData();
    },
methods:{
        updateReject(id){
            axios.post("http://127.0.0.1:8000/api/admin/process", {
                type:2,
                id:id,
            }).then((response)=>{
                this.getData();
            })
        },

        updateOkey(id){
            axios.post("http://127.0.0.1:8000/api/admin/process", {
                type:1,
                id:id,
            }).then((response)=>{
                this.getData();
            })
        },
    getData(page){
        if(typeof page === 'undefined'){
            page=1;
        }
        axios.get('http://127.0.0.1:8000/api/admin/all/?page=${page}').then((response)=>{

            this.waiting = response.data.waiting;
            this.list = response.data.list;
            this.last = response.data.last_list;
            this.reject = response.data.reject;
            this.today = response.data.today_list;
        })
    }
}
}
</script>

<style scoped>

</style>
