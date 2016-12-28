
Vue.component('v-cuztom-image', {

    mixins: [vCuztomMedia],

    methods: {

        setup: function() {
            this.type = 'file';
        },

        setPreview: function(attachment) {
            var thumbnail = attachment.sizes.medium ? attachment.sizes.medium : attachment.sizes.full;

            this.$set('preview', '<img src="'+attachment.url+'" height="'+thumbnail.height+'" width="'+thumbnail.width+'" />');
        }

    }

});