<template>


        <div class="col-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users Table</h3>
              <div class="box-tools">
                  <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Add new <i class="fa fa-user-plus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Modify</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>
                      <a href="http://">
                      <i class="fa fa-edit"></i>
                      </a>
                       <a href="http://">
                      <i class="fa fa-trash text-red"></i>
                      </a>

                  </td>
                </tr>
              </tbody></table>
            </div>
          </div>


<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addNewLabel">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

    <div class="form-group">
      <label>Name</label>
      <input v-model="form.name" type="text" name="name" placeholder="Name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>


    <div class="form-group">
      <label>Email</label>
      <input v-model="form.email" type="email" name="email" placeholder="Email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
    </div>

     <div class="form-group">
      <label>Bio</label>
      <textarea v-model="form.bio" name="bio" placeholder="Bio"
        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"> </textarea>
      <has-error :form="form" field="bio"></has-error>
    </div>

    <div class="form-group">
      <label>Role</label>
      <select v-model="form.type" name="type" placeholder="Bio"
        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
        <option value="">Select Role</option>
        <option value="admin">Admin</option>
         <option value="user">User</option>
          <option value="author">Author</option>
      </select>
      <has-error :form="form" field="type"></has-error>
    </div>

   <div class="form-group">
      <label>Password</label>
      <input v-model="form.password" name="password" placeholder="Password"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create </button>
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
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
