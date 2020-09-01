<template>
	
</template>
<script>
export default {
	data(){
		return {
			
		};
	},

	

	methods: {
    	
    	errorMessage(message){
    		Vue.$toast.error(message, {
	  			position: 'top'
			});
    	},

    	successMessage(message){
    		Vue.$toast.success(message, {
	  			position: 'top'
			});
    	},

    	showValidationError(error){
	        if(error.response && error.response.data.meta) { 
	            this.errorMessage(error.response.data.meta.message);
	        }
	        if(error.response && error.response.data.errors) {
	            var errorCount = 0;
	            for(var key in error.response.data.errors) {

	                if(errorCount == 0) {
	                    this.$parent.errors = {[key]:1};

	                    this.errorMessage(error.response.data.errors[key][0]);

	                    if($('[for="'+key+'"]')[0]) {
	                        $('[for="'+key+'"]')[0].scrollIntoView('start')
	                    }
	                }
	                errorCount++;
	            }
	        } 
	    }
      
	},

	mounted() {
	}
}
</script>