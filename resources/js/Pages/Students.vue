
<template>
    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Students Details
            </h2>
        </template>

        <div class="container">
            <div class="row">
                <div class="text-center col-lg-12">
                    <h1 class="page-title">Students</h1>
                </div>
                <div class="mt-5 col-lg-12">
                    <form @submit.prevent="taskStore">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <input class="form-control" name="name" v-model="task_form.name" type="text" placeholder="Enter a Student Name" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <input class="form-control" name="age" v-model="task_form.age" type="number" placeholder="Age" required>
                            </div>
                            <div class="form-group col-lg-1">
                                    <input class="imagePreview" ref="fileInput" type="file" @input="pickFile" :style="{'background-image': `url($(previewImage))`}" @click="selectImage" required />      
                                </div>
                            <div class="form-group col-lg-3">
                                    <select class="form-select" name="select" v-model="task_form.select"  required>
                                        <option selected>Please Select Status</option>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mt-5 col-lg-12">
                    <div>
                        <table class="table table-success table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(task,key) in task_list">
                                    <th scope="row">{{ ++key }}</th>
                                    <td>{{ task.name }}</td>
                                    <td><img img class="image w-20 h-20" src="{{ task.image }}" /></td>
                                    <td> {{ task.age }}</td>
                                    <td>
                                        <span class="badge bg-warning">Inactive</span>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button type="button" @click.prevent="deleteTask(task.id)" class="btn btn-danger"><i class="far fa-trash-alt"></i>
                                        </button>
                                        <button href="javascript:void(0)" class="btn btn-info"><i class="fas fa-pencil" onclick="taskEditModel({{ task.id }})"></i>
                                        </button>
                                        <button v-if="task.active == 0" type="button" @click.prevent="activeTask(task.id)" class="btn btn-sucess"><i class="far fa-check-circle"></i>
                                        </button>
                                        <button v-if="task.active == 1" type="button" @click.prevent="activeTask(task.id)" class="btn btn-warning"><i class="far fa-times"></i>
                                        </button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import route from 'vendor/tightenco/ziggy/src/js';

export default {
    
    data() {
        return {
            task_form: {
                name: '',
                age: '',
                images: '',
                select:''
            },
            task_list: [],
            previewImage: null
        }
    },
    beforeMount(){
        this.getTasks();
    },
    methods: {

        async getTasks(){
            const tasks = (await axios.get(route('students.list'))).data
            this.task_list = tasks
        },

        async taskStore() {
            // Inertia.post('/students/store', form)
            await axios.post(route('students.store'), this.task_form)
            this.getTasks();

            this.task_form.name = ""
        },

        async deleteTask(id) {
            await axios.delete(route('students.delete', id))
            this.getTasks();
        },

        async activeTask(id) {
            await axios.get(route('students.active', id))
            this.getTasks();
        },
        selectImage () {
            this.$refs.fileInput.click()
        },
        pickFile () {
            let input = this.$refs.fileInput
            let file = inputs.files
            if(file && file[0]) {
                let reader = new FileReader
                reader.onload = e => {
                    this.previewImage = e.target.result
                }
                render.readAsDataURL(file[0])
                this.$emit('input', file[0])
            }
        }
    }

}
</script>

<style lang="css" scoped>
.page-title{
    padding-top: 3vh;
    font-size: 2rem;
    color: #000;
}
.btn {
    color: #000;
    font-weight: 600;
}

.imagePreview {
    width: 100px;
    height: 100px;
    display: block;
    cursor: pointer;
    background-color: gray;
}

</style>