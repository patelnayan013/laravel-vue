
import Vue from "vue";
import moment from 'moment';

export default {
    install(Vue) {
		Vue.filter('ymdt',function(value){
			
			return value == null?'-':moment(value).format("D MMM YYYY HH:mm a");
		});

		Vue.filter('dmyf',function(value){			
			return value == null?'-':moment(value).format("D MMM, YYYY");
		});

		
		
		Vue.filter('dob',function(date){
			if(date == null) {
				return '-';
			}
			var sdt = new Date(date);
			var difdt = new Date(new Date() - sdt);
			
			var years = (difdt.toISOString().slice(0, 4) - 1970);
			var months = (difdt.getMonth()+1);
			var days = difdt.getDate();

		    if(years != 0 && months !=0) {
		    	return years+'y '+ months+'mo';
		    }
		    if(years != 0 && months ==0 && days != 0) {
		    	return years+'y '+ days+'d';
		    }

		    if(months != 0 && days !=0) {
			    return months+'mo '+days+'d';
			}

			if(months == 0 && days !=0) {
			    return days+'d';
			}

		});
		
		Vue.filter('currency',function(value) {
	    	return  value == null?'-':value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')
		});
		
	}
}


