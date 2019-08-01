<style>
.widget-user .widget-user-header {
    background-position: center center;
    background-size: cover;
    height: 300px;
}

</style>


<template>
<div class="col-12 mt-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header"
            style="background-image: url('/img/tide.jpg'); ">
              <h3 class="widget-user-username">Alexander Pierce</h3>
              <h5 class="widget-user-desc">Founder &amp; CEO</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">3,200</h5>
                    <span class="description-text">SALES</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">13,000</h5>
                    <span class="description-text">FOLLOWERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">35</h5>
                    <span class="description-text">PRODUCTS</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Activity</a></li>

              <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="activity">
                <!-- Post -->
                <h1>POSTS</h1>
              </div>

              <div class="tab-pane active" id="settings">
                <form class="form-horizontal">

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" v-model="form.name" class="form-control" id="name" name="name" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                    <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                   <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Bio</label>
                    <div class="col-sm-10">
                       <textarea
                  v-model="form.bio"
                  name="bio"
                  placeholder="Bio"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bio') }"
                >
                 <has-error :form="form" field="bio"></has-error>
                </textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputImage" class="col-sm-2 control-label">Profile Picture</label>
                    <div class="col-sm-10">
                      <input type="file" @change="updateProfile" class="" id="inputImage">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Password (Leave empty when not changing)</label>
                    <div class="col-sm-10">
                        <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  placeholder="Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                  <has-error :form="form" field="password"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" @click.prevent="updateInfo" class="btn btn-success">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        </div>


</template>

<script>
    export default {
        data (){
            return {
              form: new Form({
                    id:'',
                    name: "",
                    email: "",
                    password: "",
                    type: "",
                    bio: "",
                    photo: ""
                 })
            }
        },

        methods: {
            //update profile picture
            updateProfile(e){
            let file = e.target.files[0];
            console.log(file);
            var reader = new FileReader();

            if(file['size'] < 2111775){
                 reader.onloadend =  (file)=>{
                // console.log('RESULT', reader.result)
                this.form.photo = reader.result;
                 }
              reader.readAsDataURL(file);
            }
            else {
                 swal.fire({
                type: 'error',
                title: 'File too large!'

                })
            }

            },

            updateInfo(){
                this.$Progress.start();
                this.form.put('api/profile/')
                    .then(()=>{

                    this.$Progress.finish();
                    })
                    .catch(()=>{
                    this.$Progress.fail();
                    })
            },

            getProfilePhoto(){
                 let prefix = (this.form.photo.match(/\//) ? '' : '/img/profile/');
                 return prefix + this.form.photo;
            }
        },
        mounted() {
            console.log('Component mounted.')
        },

        created () {
              axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data)));
        }
    }
</script>
