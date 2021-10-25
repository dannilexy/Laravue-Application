<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="openModal"><i class="fas fa-user-plus"> Add New</i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Reistered At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td><span class="tag tag-success">{{user.type | upText}}</span></td>
                      <td><span class="tag tag-success">{{user.created_at | myDate}}</span></td>
                      <td>
                        <a href="#" class="btn" @click="openEditModal(user)">
                            <i class="fas fa-edit yellow"></i> </a>/
                        <a href="#" class="btn"  @click="deleteUser(user.id)">
                            <i class="fas fa-trash red"></i>
                        </a>
                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>




    <!-- Modal Area -->
<div class="modal" id="addNew">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{editMode ? "Update User Record" : "Add New User"}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form @submit.prevent=" editMode ? updateUser() : createUser()" @keydown="form.onKeydown($event)">
      <div class="modal-body">
       <div class="form-group">
            <label for="name">name</label>
            <input v-model="form.name" type="text" class="form-control" name="name" placeholder="Full Name">
            <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" class="text-danger" />
       </div>
       <div class="form-group">
            <label for="name">email</label>
            <input v-model="form.email" type="email" class="form-control" name="email" placeholder="Email Address">
            <div v-if="form.errors.has('email')" v-html="form.errors.get('email')"  class="text-danger"  />
       </div>

       <div class="form-group" v-show="!editMode">
            <label for="name">password</label>
            <input v-model="form.password" type="password" class="form-control" name="password" placeholder="password">
            <div v-if="form.errors.has('password')" v-html="form.errors.get('password')"  class="text-danger"  />
       </div>
       <div class="form-group">
            <label for="name">type</label>
            <select class="form-control" v-model="form.type" name="type" id="type">
            <option value="">--Select User Role--</option>
            <option value="admin">Admin</option>
            <option value="user">Standard User</option>
            <option value="author">Author</option>
            </select>
            <div v-if="form.errors.has('type')" v-html="form.errors.get('type')"  class="text-danger"  />
       </div>
       <div class="form-group">
            <label for="name">bio</label>
            <textarea  v-model="form.bio" class="form-control" name="bio" placeholder="short bio (Optional)" id="bio"  rows="3"></textarea>
            <div v-if="form.errors.has('bio')" v-html="form.errors.get('name')"  class="text-danger"  />
       </div>
       <!-- <div class="form-group">
            <label for="name">photo</label>
            <input  type="file" class="form-control" name="name" placeholder="name">
            <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
       </div> -->
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">{{editMode ? "Update" : "Create"}}</button>
      </div>
</form>
    </div>
  </div>
</div>




    </div>
</template>

<script>
    export default {

     data: () => ({
         editMode : true,
        users : {},
        form: new Form({
            id:'',
            name: '',
            email: '',
            password: '',
            type: '',
            bio: '',
            photo: ''
    })
  }),
  methods: {
      updateUser(){
           this.$Progress.start();
        //    console.log("Editing User")
        this.form.put('api/user/' + this.form.id)
        .then(()=>{
            //on success action

             Swal.fire(
            'Updated!',
            'user info updated successfully!.',
            'success'
            );
             Fire.$emit('ActionDone');
             $('#addNew').modal('hide');
             this.$Progress.finish();
        })
        .catch(()=>{
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Oops...',
            //     text: 'Something went wrong!',
            //     })
            //      $('#addNew').modal('hide');
             this.$Progress.fail();
            //on error
        });
        },

      //Open Modal function
      openModal(){
          this.editMode = false;
          this.form.reset();
          $('#addNew').modal('show');
      },
      openEditModal(user){
          this.editMode = true;
          this.form.reset();
          $('#addNew').modal('show');
          this.form.fill(user);
      },


      //Deleting users
      deleteUser(id){
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
           const response =  this.form.delete('/api/user/'+id).then( ()=>{
            Fire.$emit('ActionDone');
             Swal.fire(
            'Deleted!',
            'user was deleted!.',
            'success'
            )
            })
            .catch(()=>{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                })
            });

  }
})
      },

      //Getting all users
      loadUsers(){
          axios.get("api/user").then(({data})=> (this.users=data.data))
      },

      createUser(){
        this.$Progress.start();
        const response =  this.form.post('/api/user').then(
            ()=>{
                Fire.$emit('ActionDone');
            $('#addNew').modal('hide');
          toast.fire({
            icon: 'success',
            title: 'User created successfully!'
            })
        this.$Progress.finish();
            }
        ).catch(
            ()=>{

            }
        );

      }
  },

        created() {
           this.loadUsers();
           Fire.$on('ActionDone',  () => {this.loadUsers()})
        //    setInterval( () =>this.loadUsers(), 3000); //resend te request to te backend every 3 secs
        }
    }
</script>
