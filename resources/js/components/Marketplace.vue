<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Market Place Table</h1>

                        <div class="card-tools">                            
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="newProject"
                            >
                                Add New Project
                                <i class="fa fa-user-plus fa-fw"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Project Name</th>
                                    <th scope="col">Project Location</th>
                                    <th scope="col">Project Image</th>
                                    <th scope="col">Project Description</th>
                                    <th scope="col">Project Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="project in marketplaces" :key="project.project_id">
                                    <td>{{ project.project_id }}</td>
                                    <td>{{ project.project_name }}</td>
                                    <td>{{ project.project_location }}</td>
                                    <!-- <td v-if="project.project_image == ''">
                                        <img src="/data/placeholder.png"  alt="image" width="70" height="50">
                                    </td> -->
                                    <td>
                                        <img :src="'/' + project.project_image"  alt="image" width="70" height="50">
                                    </td>
                                    <td class="w-25">{{ project.project_desc }}</td>
                                    <td v-if="project.project_status == 'posted'">
                                        <span class="badge badge-pill badge-success"  >{{ project.project_status.charAt(0).toUpperCase() + project.project_status.substr(1) }}</span>
                                    </td>
                                    <td v-else>
                                        <span class="badge badge-pill badge-warning" >{{ project.project_status.charAt(0).toUpperCase() + project.project_status.substr(1) }}</span>
                                    </td>
                                    <td>                                       
                                        <a @click="editProject(project)" class="btn btn-success btn-sm">
                                            <i class="fa fa-edit fa-fw" data-toggle="tooltip" title="Edit"></i>
                                        </a>
                                        <a @click="deleteProject(project.id)" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash fa-fw" data-toggle="tooltip" title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>                    
                            </tbody>
                        </table>
                    </div>                
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="projectModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="projectModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel">
                            
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateProject() : createProject()">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Project Name</label>
                                        <input
                                            v-model="form.project_name"
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has('project_name')
                                            }"
                                        />
                                        <has-error :form="form" field="project_name"></has-error>
                                    </div>
                                </div>    
                                <div class="col-sm-4">
                                    <label>Status</label>
                                    <div class="form-group">
                                        <select name="project_status" id="project_status" class="form-control" v-model="form.project_status" :class="{'is-invalid': form.errors.has('project_location')}" >
                                            <!-- <option :value="null" selected> Select status</option> -->
                                            <option value="posted">Posted</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                        <has-error :form="form" field="project_status"></has-error>                                       
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Project Location</label>
                                        <input
                                            v-model="form.project_location"
                                            type="text"
                                            name="project_location"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has('project_location')
                                            }"
                                        />
                                        <has-error :form="form" field="project_location"></has-error>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Project Price</label>
                                        <!-- <div class="input-group mb-3"> -->
                                            <!-- <div class="input-group-prepend"> -->
                                                <!-- <span class="input-group-text" id="basic-addon1">PHP</span> -->
                                            <!-- </div> -->
                                            <input
                                            v-model="form.project_price"
                                            type="text"
                                            name="project_price"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has('project_price')
                                            }"
                                            />                                    
                                        <has-error :form="form" field="project_price"></has-error>                                       
                                        <!-- </div> -->
                                       
                                    </div>
                                </div>
                            </div>                  
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Project Description</label>
                                        <textarea v-model="form.project_desc" class="form-control" rows="6" placeholder="Enter Project description" :class="{
                                                'is-invalid': form.errors.has('project_desc')
                                            }"></textarea>
                                        <has-error :form="form" field="project_desc"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Project Image (optional)</label>

                                        <div class="custom-file">
                                            <input type="hidden" v-model="form.project_image" class="image-name" name="project_image" id="project_image">
                                            <input type="file" class="custom-file-input" id="project_image" ref="file"  name="project_image" @change="fileUpload">       
                                            <!-- <input type="file" id="file" ref="file" @change="fileUpload"/> -->
                                            <div></div>                                                 
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <has-error :form="form" field="project_image"></has-error>
                                        </div>
                                    </div>                        
                                </div>
                            </div>        

                            <div class="form-group">
                            </div>
                        </div>
                        <div class="card-footer">               
                            <button type="submit" class="btn btn-primary float-right" ref="submit">
                                Create New Project
                            </button>
                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Form from 'vform'

	export default {     
        data() {
            return {
                // laravelData: {},
                marketplaces : {},
                form: new Form({
                    project_id: '',
					project_name: '',
                    project_location: '',
                    project_price : '',
                    project_desc : '',
                    project_status : '',                    
                    project_image : '',
                    project_image_name : '',
				}),
            }
        },   		
        methods : {            
            fileUpload (e) {
                // this.file = this.$refs.file.files[0];
                this.project_image = e.target.files[0];
                $('.custom-file-label').html(this.project_image.name)

                var fileReader = new FileReader()
                fileReader.readAsDataURL(this.project_image)

                fileReader.onload = (e) => {
                    this.form.project_image = e.target.result
                    this.form.project_image_name = this.project_image.name
                }
                

            }, 
            newProject() {
                this.editmode = false;
                this.form.reset();
                $('#projectModal').modal('show');
                $('#projectModalLabel').html('Add new Project');
            },
            viewProject(project) {
                // this.form.get(`/user/${user}`); 
                this.form.fill(project);
                
                $('#projectModal').modal('show');
                $('#projectModalLabel').html('View Project');
                $('.form-control').attr('readonly');
            },
            editProject(project) {
                // console.log($('.image-name').val());
                this.editmode = true;
                this.form.reset();
                $('.custom-file-label').html($('.image-name').val())
                $('#projectModal').modal('show');
                $('#projectModalLabel').html('Edit Project');
                this.form.fill(project);
            },           
            loadProjects() {        
                axios.get('marketplace').then(( {data}) => (
                    this.marketplaces = data.data
                ))
                .catch(function(error) {
                    console.log(error);
                });                
            },
            createProject() {
                this.form.post('marketplace', this.form)
                .then(({ data }) => {
                    console.log(data);
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    })
                    $('#projectModal').modal('hide');
                    this.loadProjects();
                })
                .catch(()=> {
                    Toast.fire({
                        icon: data.status,
                        title: data.message                           
                    })
                });       
            },
            updateProject() {
                this.form.put(`marketplace/${this.form.project_id}`)
                .then(( { data }) => {
                    // success
                    $('#projectModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        data.message,
                        data.status
                    )    
                    this.loadProjects();               
                })
                .catch(() => {
                    
                });
            }
        },        		
        created() {
            this.loadProjects();
        },
		mounted() {
            console.log('Component mounted.')
		}
	}
</script>
