
Vue.component('v-cuztom-repeatable', {

    props: [],


    data: function() {
        return {
            list: ['hoi', 'hoi'],
        }
    },


    mounted: function() {
        console.log('repeatable ready');
    },


    methods: {

        addItem: function() {
            console.log('add item');

            this.list.push('hoi');
        }

    }

});