<template>
    <div class="box">
        <div class="col-md-12">
            <div class="box-tools">
                <button class="btn btn-success btn-block" data-toggle="modal" data-target="#exampleModal">Select User <i class="fa fa-envelope"></i></button>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Choose a user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                       <form @submit.prevent="sendEmail()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Users Lsit</label>
                            <select v-model="form.email" name="email" id="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <option  v-for="user in users.data" :key="user.id" >{{user.email}}</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                          <div class="form-group">
                            <label>Subject</label>
                           <input v-model="form.subject" type="text" name="subject" placeholder="Subject" class="form-control" :class="{ 'is-invalid': form.errors.has('subject') }"/>
                            <has-error :form="form" field="text"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea v-model="form.text" name="text" id="text" placeholder="Message" class="form-control" :class="{ 'is-invalid': form.errors.has('text') }"></textarea>
                            <has-error :form="form" field="text"></has-error>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                       </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
                return {
                    form: new Form({
                        id:'',
                        email: '',
                        text: '',
                        subject:''
                    }),
                    users: []
                }
            },
            methods: {
                getUsers() {
                    axios.get('api/user')
                        .then((res) => {
                            this.users = res.data
                        })
                },
                sendEmail(){
                        $('#exampleModal').modal('hide');
                        $(".modal-backdrop").remove();
                         let loader = this.$loading.show({
                            container: this.fullPage ? null : this.$refs.formContainer,
                            onCancel: this.onCancel,
                            color: '#c91010',
                            loader: 'bars',
                            width: 80,
                            height: 100,
                            })
                         this.form.post('api/sendemail')
                          .then(()=>{
                            swal.fire("Email sent!", "", "success");   
                            loader.hide()                        
                          })
                          .catch((e)=>{
                               swal.fire("Something went wrong", "", "error");   
                              console.log(e)
                          })
                }
            },
            created() {
                this.getUsers();
                console.log('Component mounted.')
            }
    }
</script>