
Vue.component('v-cuztom-repeatable', {

    props: [],

    data: function() {
        return {
            list: ['hoi', 'hoi'],
        }
    },

    mounted: function() {
        this.onReady();
    },

    ready: function() {
        this.onReady();
    },

    methods: {

        onReady: function() {

        },


        addItem: function() {
            console.log('add item');

            this.list.push('hoi');
        }

    }

});