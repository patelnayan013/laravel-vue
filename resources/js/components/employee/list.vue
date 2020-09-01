<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        	<div class="card">
                <div class="card-header">Employee List</div>

                <div class="card-body">
                	<a href="/employee/create" @click="navigate('edit')" class="btn btn-primary text-white">Add</a>

                	<a href="javascript:void(0);" @click="navigate('view')" class="btn btn-success text-white">View</a>

                	<a href="javascript:void(0);" @click="navigate('edit')" class="btn btn-info text-white">Edit</a>                	

                	<a href="javascript:void(0);" @click="navigate('delete')" class="btn btn-danger	 text-white">Delete</a>

                	<div>&nbsp;</div>
				    <ag-grid-vue style="width: 100%; height: 50vh;"
				                 class="ag-theme-alpine"
				                 :columnDefs="columnDefs"
				                 :rowData="rowData"				                 
				                 rowSelection="single"
				                 @grid-ready="onGridReady">
				    </ag-grid-vue>
				</div>
			</div>
		</div>
	</div>

	 <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-lg" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalLabel">View Employee</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
		      	<div class="modal-body">
		        	<table class="table table-bordered">
		        		<tr>
		        			<td class="vhead">First Name</td>
		        			<td>{{first_name}}</td>
		        			<td class="vhead">Last Name</td>
		        			<td>{{last_name}}</td>
		        		</tr>
		        		<tr>
		        			<td class="vhead">Phone Number</td>
		        			<td>{{phone_number}}</td>
		        			<td class="vhead">Email</td>
		        			<td>{{email}}</td>
		        		</tr>
		        		<tr>
		        			<td class="vhead">D.O.B</td>
		        			<td>{{date_of_birth | dmyf}}</td>
		        			<td class="vhead">Salary</td>
		        			<td>{{salary}}</td>
		        		</tr>
		        	</table>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
		      	</div>
		    </div>
		 </div>
	</div>
	<validation ref="error"></validation>
</div>
</template>

<script>
import moment from 'moment';
import {AgGridVue} from "ag-grid-vue";
import "../../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
import "../../../../node_modules/ag-grid-community/dist/styles/ag-theme-alpine.css";
export default {
    name: 'App',
    data() {
        return {
            columnDefs: null,
            rowData: null,
            
            first_name:null,
			last_name:null,
			phone_number:null,
			email:null,
			date_of_birth:null,
			salary:null,

        }
    },
    components: {
        AgGridVue
    },

    methods:{

    	selected(){
    		alert("eert");
    	},
    	onGridReady(params) {
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
        },

        navigate(type) {
            const selectedNodes = this.gridApi.getSelectedNodes();
            const selectedData = selectedNodes.map( node => node.data );
            if(!selectedData[0]) {
            	this.$refs.error.errorMessage('Select row please');
            	return
            }
            if(type == 'view') {

            	this.first_name = selectedData[0].first_name;
				this.last_name = selectedData[0].last_name;
				this.phone_number = selectedData[0].phone_number;
				this.email = selectedData[0].email;
				this.date_of_birth = selectedData[0].date_of_birth;
				this.salary = selectedData[0].salary;

            	$("#employeeModal").modal('show');
            	return;
            }
            location.href = '/employee/'+type+'/'+selectedData[0].id;

        },

    	init(page){

            axios.get('/get-employee-data?page='+page ).then(response => {
                var data = response.data.employee.data.data;
                var rows = [];
                $(data).each((k,v) => {
                	rows.push({
                		checkboxSelection:true,
                		id:v.id,
                		first_name: v.first_name, 
                		last_name: v.last_name,
                		phone_number: v.phone_number,
                		email: v.email,
                		date_of_birth: this.dmy(v.date_of_birth),
                		salary: this.currency(v.salary),
                	})
                });
                this.rowData = rows;
            });
    	},

    	dmy(value){
    		return value == null?'-':moment(value).format("D MMM, YYYY");
    	},

    	currency(value) {
	    	return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')
		}
    },

    mounted() {
    	this.init(1);
    },

    beforeMount() {
        this.columnDefs = [
            {headerName: 'First Name', field: 'first_name'},
            {headerName: 'Last Name', field: 'last_name'},
            {headerName: 'Phone Number', field: 'phone_number'},
            {headerName: 'Email', field: 'email'},
            {headerName: 'DOB', field: 'date_of_birth'},
            {headerName: 'Salary', field: 'salary'}
        ];
    }
}
</script>
