import Vue from 'vue'

Vue.filter('getCity',  value => {
    // TODO: check a better way to obtain city
    return value.split(',')[1];
});