
vCuztomMedia = {

    props: [
        'id',
        'attachment',
    ],

    data: function() {
        return {
            type: null,
            uploader: null,
            value: null,
            preview: null
        }
    },

    ready: function() {
        var vm = this;

        // Setup
        this.setup();

        // Set preview
        if(this._attachment) {
            this.setPreview(this._attachment);
        }

        // Init wp media
        this.uploader = wp.media.frames.file_frame = wp.media({
            type: vm.type,
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
        }

    },

    computed: {

        _attachment: function() {
            return JSON.parse(this.attachment);
        },

    }

}