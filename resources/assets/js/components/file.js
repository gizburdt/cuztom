
Vue.component('v-cuztom-file', {

    mixins: [vCuztomMedia],

    methods: {

        setup: function() {
            this.type = 'file';
        },

        setPreview: function(attachment) {
            this.$set('preview', '<a target="_blank" href="'+attachment.url+'">'+attachment.title+'</a>');
        }

    }

});