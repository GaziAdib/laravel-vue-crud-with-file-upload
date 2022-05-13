<template>
    <div class="container mt-2 mb-2 pd-2">

         <div class="form-group">
           <label for="name">Upload Image</label>
           <input
                type="file"
                id="image"
                class="form-control"
                name="image"
                @change="onFileChange"
           >
       </div>
       <div class="form-group">
           <label for="name">Name</label>
           <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter Name"
                class="form-control"
                v-model="item.name"
           >
       </div>
       <div class="form-group">
           <label for="email">Email</label>
           <input
                type="text"
                id="email"
                name="email"
                placeholder="Enter Email"
                class="form-control"
                v-model="item.email"
           >
       </div>
       <div class="form-group">
           <label for="phone">Phone</label>
           <input
                type="text"
                id="phone"
                name="phone"
                placeholder="Enter Phone"
                class="form-control"
                v-model="item.phone"
           >
       </div>
       <div class="form-group">
           <label for="speiciality">Speiciality</label>
           <input
                type="text"
                id="speiciality"
                name="spciality"
                placeholder="Enter Speiciality"
                class="form-control"
                v-model="item.speciality"
           >
       </div>
       <button
        @click="save"
         class="btn btn-success btn-block mt-2 mb-2 pd-2"
         >
         {{ isEditing ? 'Update':'Save'}}
         </button>


    <div class="col-md-12 mt-3" v-if="lists.length > 0">
        <h2 class="text-center">Doctor Name</h2>
        <ul class="list-group">
            <li
             class="list-group-item"
             v-for="doctor in lists"
             :key="doctor.id"
             >
              <img :src="doctor.image" height="50px;" width="50px;" class="img-circle" alt="Services" />   {{ doctor.name }} - {{ doctor.phone }}
                <span style="float: right;">
                    <button class="btn btn-warning btn-sm mr-2" @click="editDoctor(doctor)">Edit</button>
                    <button class="btn btn-danger btn-sm mr-2" @click="deleteDoctor(doctor.id)">Delete</button>

                </span>
            </li>

        </ul>
    </div>

    </div>
</template>


<script>
import axios from "axios";

export default {
    name: "TestComponent",
    data() {
        return {
            lists: [],
            item:{
                image: "",
                name:"",
                email: "",
                phone: "",
                speciality: ""
            },
            temp_id: null,
            isEditing: false
        }
    },

    mounted() {
        this.fetchAll();
    },
    methods: {

    // Image Upload

    onFileChange(e) {
        this.item.image = e.target.files[0];
    },

    // get All the Data
        fetchAll() {
            axios.get('/api/doctors')
            .then(res => {
                this.lists = res.data
            })
        },

    // save Data to server
        save() {

        const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('image', this.item.image);
            formData.append('name', this.item.name);
            formData.append('email', this.item.email);
            formData.append('phone', this.item.phone);
            formData.append('speciality', this.item.speciality);

            let method = axios.post;
            let url = '/api/doctors';

            if(this.isEditing) {
                method = axios.patch;
                url = `/api/doctors/${this.temp_id}`;

                // then edit
                let editedFormData = new FormData();

                formData.append('image', this.item.image);
                formData.append('name', this.item.name);
                formData.append('email', this.item.email);
                formData.append('phone', this.item.phone);
                formData.append('speciality', this.item.speciality);

                method(url, editedFormData, config)
                .then(res => {
                    this.fetchAll();
                    this.temp_id = null;
                    this.isEditing = false;
                })
            } else {

                try{
                    method(url, formData, config)
                    .then(res => {
                        this.fetchAll();
                        this.item = {
                                image: "",
                                name: "",
                                email: "",
                                phone: "",
                                speciality: ""
                        },
                        this.temp_id = null;
                    this.isEditing = false;
                    })
                }catch(e) {
                        console.log(e);
                    }
                }
        }
        ,



// Delete a Doctor
       deleteDoctor(id) {
            try{
                axios.delete(`/api/doctors/${id}`)
                .then(res => this.fetchAll())
            } catch(e) {
                console.log(e);
            }
        },


        // Edit Doctor

        editDoctor(doctor){
            this.item = {
                image: doctor.image,
                name: doctor.name,
                email: doctor.email,
                phone: doctor.phone,
                speciality: doctor.speciality
            }
            this.temp_id = doctor.id;
            this.isEditing = true
        }

    }
}

</script>

