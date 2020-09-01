<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Employee</div>

                <div class="card-body">
                    
                    <form id="employeeForm">
                    	<div v-show="step==1">
	                    	<div class="form-group">
	                    		<div class="col-12">
				                    <label for="first_name" :class='"mb-0  "+[errors.first_name ? "text-danger" : ""]'>First Name</label>
				                    <input type="text" name="first_name" v-model="first_name" :class='"form-control "+[errors.first_name ? "is-invalid" : ""]'>
				                </div>
				            </div>

	                    	<div class="form-group">
	                    		<div class="col-12">
				                    <label for="last_name" :class='"mb-0  "+[errors.last_name ? "text-danger" : ""]'>Last Name</label>
				                    <input type="text" name="last_name" v-model="last_name" :class='"form-control "+[errors.last_name ? "is-invalid" : ""]'>
				                </div>
				            </div>

				            <div class="form-group">
	                    		<div class="col-12">
				                    <label for="phone_number" :class='"mb-0  "+[errors.phone_number ? "text-danger" : ""]'>Phone Number</label>
				                    <input type="number" name="phone_number" v-model="phone_number" :class='"form-control "+[errors.phone_number ? "is-invalid" : ""]'>
				                </div>
				            </div>

				            <div class="form-group">
	                    		<div class="col-12">
				                    <label for="email" :class='"mb-0  "+[errors.email ? "text-danger" : ""]'>Email</label>
				                    <input type="email" name="email" v-model="email" :class='"form-control "+[errors.email ? "is-invalid" : ""]'>
				                </div>
				            </div>
			            </div>

			            <div v-show="step==2">
				            <div class="form-group">
	                    		<div class="col-12">
				                    <label for="date_of_birth" :class='"mb-0  "+[errors.date_of_birth ? "text-danger" : ""]'>Date of Birth</label>
				                    <input type="date" name="date_of_birth" v-model="date_of_birth" :class='"form-control "+[errors.date_of_birth ? "is-invalid" : ""]'>
				                </div>
				            </div>

				            <div class="form-group">
	                    		<div class="col-12">
				                    <label for="salary" :class='"mb-0  "+[errors.salary ? "text-danger" : ""]'>Salary</label>
				                    <input type="number" name="salary" v-model="salary" :class='"form-control "+[errors.salary ? "is-invalid" : ""]'>
				                </div>
				            </div>
			            </div>

                    	<div class="form-group row">
                    		<div class="col-6 text-left" >
                    			<a href="javascript:void(0);" v-if="step==2" class="btn text-white btn-info" @click='step=1'>Prev</a>
                    		</div>

                    		<div class="col-6 text-right">
                    			<a href="javascript:void(0);" class="btn text-white btn-info" @click="validateForm()">{{step==1?'Next':'Create'}}</a>
                    		</div>
                    	</div>

                    </form>
                    <validation ref="error"></validation>
                </div>	
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
	data(){
		return {
			loading:true,
			errors:[],

			first_name:'',
			last_name:'',
			phone_number:'',
			email:'',
			date_of_birth:'',
			salary:'',

			step:1
		};
	},


	methods:{
		validateForm(){
			this.errors = [];
            this.loading = true;

			var data = $("#employeeForm").serialize();
			axios.post('/employee/save?step='+this.step,data).then(response => {
				this.loading = false;
                if(response.data.meta.code == 200) {                   
                    if(this.step == 1) {
                    	this.step = 2;
                    	return;
                	}
                	this.$refs.error.successMessage(response.data.meta.message);
                	this.resetForm();
                    return;
                }
                this.$refs.error.errorMessage(error);
            }).catch(error => {
            	this.$refs.error.showValidationError(error);
                this.loading = false;
            });
		},

		resetForm(){
			this.first_name = "";
			this.last_name = "";
			this.phone_number = "";
			this.email = "";
			this.date_of_birth = "";
			this.salary = "";

			this.step = 1;
		}
	},

    mounted() {
        console.log('Component mounted.')

        
    }
}
</script>