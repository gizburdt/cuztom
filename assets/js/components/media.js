
Vue.component('v-cuztom-media', {

    props: [
        'type',
        'attachment',
    ],

    data: function() {
        return {
            type: null,
            attachment: null,
            uploader: null,
            value: null
        }
    },

    ready: function() {
        var vm = this;

        // Set preview
        this.setPreview(this._attachment);

        // Init wp media
        this.uploader = wp.media.frames.file_frame = wp.media({
            type: 'image',
            multiple: false,
        });

        // When image selected
        this.uploader.on('select', function() {
            var attachment = vm.uploader.state().get('selection').first().toJSON();

            vm.setPreview(attachment);

            vm.$set('value', attachment.id);
        });
    },

    methods: {

        chooseMedia: function() {
            this.uploader.open();
        },

        removeMedia: function() {
            this.$set('value', null);
            this.$set('preview', null);
        },

        setPreview: function(attachment) {
            if(this._isImage) {
                var thumbnail = attachment.sizes.medium ? attachment.sizes.medium : attachment.sizes.full;

                this.$set('preview', '<img src="'+attachment.url+'" height="'+thumbnail.height+'" width="'+thumbnail.width+'" />');
            } else {
                this.$set('preview', '<a target="_blank" href="'+attachment.url+'">'+attachment.title+'</a>');
            }
        }

    },

    computed: {

        _attachment: function() {
            return JSON.parse(this.attachment);
        },

        _isImage: function() {
            return this.type == 'image';
        },

        _isFile: function() {
            return ! this._isImage
        },

    }

});