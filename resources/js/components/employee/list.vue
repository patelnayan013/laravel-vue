<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        	<div class="card">
                <div class="card-header">Employee List</div>

                <div class="card-body">
                	<a href="javascript:void(0);" @click="navigate('edit')" class="btn btn-info text-white">Edit</a>

                	<a href="javascript:void(0);" @click="navigate('view')" class="btn btn-success text-white">View</a>

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
            rowData: null
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
            location.href = '/employee/'+type+'/'+selectedData[0].id;

        },

    	init(page){

            axios.get('/get-employee-data?page='+page ).then(response => {
                var data = response.data.employee.data.data;
                var rows = [];
                $(data).each((k,v) => {
                	console.log(v);
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

        // this.rowData = [
        //     {make: 'Toyota', model: 'Celica', price: 35000},
        //     {make: 'Ford', model: 'Mondeo', price: 32000},
        //     {make: 'Porsche', model: 'Boxter', price: 72000}
        // ];
    }
}
</script>
