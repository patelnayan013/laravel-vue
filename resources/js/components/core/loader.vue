<template>
	<div class="loader-div" v-if="loading">
        <div class="duv"></div>
        <div class="loader-img-div">
            <div class="spinner-border avatar-lg text-primary" role="status"></div>
        </div>
    </div>
</template>

<script>
export default {
	
	props:['loading'],
	data(){
        return {
           
        }
    },
    methods: {
        
        
    },
    mounted() {
        
    }
}
</script>