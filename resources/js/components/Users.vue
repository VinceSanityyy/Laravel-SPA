<template>
  <div class="col-12" >
    <div class="box" v-if="$gate.isAdmin()" >
      <div class="box-header" >
        <h3 class="box-title" >Users Table</h3>
        <div class="box-tools">
          <button class="btn btn-success" @click="newModal"  data-toggle="modal" data-target="#addNew">
            Add new
            <i class="fa fa-user-plus"></i>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <!-- <table id="myTable" name="myTable" class="table table-hover">
          <tbody>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Type</th>
              <th>Registered</th>
              <th>Modify</th>
            </tr>
    
            <tr v-for="user in users.data" :key="user.id">
              <td>{{user.id}}</td>
              <td>{{user.name}}</td>
              <td>{{user.email}}</td>
              <td>{{user.type| upText}}</td>
              <td>{{user.created_at| myDate}}</td>
              <td>
                <a href="#"  data-toggle="modal" data-target="#addNew" @click="editModal(user)">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="#" @click="deleteUser(user.id)">
                  <i class="fa fa-trash text-red"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table> -->
        <ag-grid-vue style="width: auto; height: 500px;"
          class="ag-theme-balham"
          :columnDefs="columnDefs"
          :rowData="rowData">
        </ag-grid-vue>
      </div>
      <div class="class card-footer">
          <!-- <pagination :data="users" @pagination-change-page="getResults"></pagination> -->
      </div>
    </div>

    <div v-if="!$gate.isAdmin()">
        <h3 style="text-align:center">Access Denied</h3>
        <not-found></not-found>
    </div>
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 v-show="!editmode" class="modal-title" id="addNewLabel">Add User</h4>
               <h4 v-show="editmode" class="modal-title" id="addNewLabel">Update User Info</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form @submit.prevent="editmode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <label>Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <label>Email</label>
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

              <div class="form-group">
                <label>Bio</label>
                <textarea
                  v-model="form.bio"
                  name="bio"
                  placeholder="Bio"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bio') }"
                ></textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>

              <div class="form-group">
                <label>Role</label>
                <select
                  v-model="form.type"
                  name="type"
                  placeholder="Bio"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value>Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                  <option value="author">Author</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <label>Password</label>
                <input
                  v-model="form.password"
                  name="password"
                  placeholder="Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import {AgGridVue} from "ag-grid-vue"
import modify_button from "./ModifyActionComponent"

export default {
  data() {
    return {
      editmode: false,
      users: {},
      form: new Form({
        id:'',
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: ""
      }),
      columnDefs: null,
      rowData: null
    };
  },
  components: {
    AgGridVue,
    modify_button
  },
  beforeMount() {
    this.columnDefs = [
        {headerName: 'ID', field: 'id'},
        {headerName: 'Name', field: 'name'},
        {headerName: 'Email', field: 'email'},
        {headerName: 'Type', field: 'type'},
        {headerName: 'Registered', field: 'created_at'},
        {headerName: 'Modify', field: 'id', cellRendererFramework: 'modify_button' },
    ];
  },
  methods: {
    updateUser(){
       this.form.put('api/user/' +this.form.id)
        .then(()=> {
            $('#addNew').modal('hide');
             $(".modal-backdrop").remove();
            swal.fire("User Updated!", "", "success");
            Fire.$emit("AfterCreate")
             this.$Progress.finish();
        })
        .catch(()=>{
            this.$Progress.fail();
        });
      },
    editModal(user){
        this.editmode = true;
         this.form.reset();
         $('#addNew').modal('show');
         this.form.fill(user);
    },
      newModal(){
          this.editmode = false;
          this.form.reset();
          $('#addNew').modal('show');
    },
    loadUsers() {
            if(this.$gate.isAdmin()){
                 axios.get("api/user").then(({ data })=>{
                   this.rowData = data.data
                 })
              
            }
    },
    createUser() {
      this.$Progress.start();
      this.form.post("api/user")
      .then(({data}) => {
        $("#addNew").modal("hide");
        $(".modal-backdrop").remove();
        toast.fire({
          type: "success",
          title: "User Created!",
          position: "top-end"
        });
        this.rowData.push(data)
      });
      this.$Progress.finish();
    },
    deleteUser(id) {
      swal.fire({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
          //send delete request
           if (result.value) {
          this.form.delete('api/user/' +id)
            .then(()=>{
                swal.fire("Deleted!", "", "success");
                //  Fire.$emit("AfterCreate")
               let userIndex = this.rowData.findIndex((data) =>{
                 return data.id == id
               })

               this.rowData.splice(userIndex,1)
            })
            .catch(()=>{
                swal.fire("Something went wrong.", "", "warning");
            });
           }
      });
    },
    // Our method to GET results from a Laravel endpoint
		getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
		}
  },
  created()
     {
         Fire.$on('searching', ()=> {
             let query = this.$parent.search
             axios.get('api/findUser?q=' +query)
                .then((data)=>{
                    this.users = data.data
                })
                .catch(()=>{
                     swal.fire("Something went wrong.", "", "warning");
                })
         })

  
        
            this.loadUsers();
    },
  mounted() {
    Fire.$on('updated', data => {
      this.editModal(data)
    })

    Fire.$on('deleted', id => {
      this.deleteUser(id)
    })
  }
    
};
</script>

