
Vue.component('v-cuztom-repeatable', {

    props: {
        id: String,
        list: {
            type: Array,
            default: []
        }
    },

    data: function() {
        return {
            id: null,
            list: [],
            ajaxUrl: null,
            ajaxPayload: null
        }
    },

    ready: function() {
        this.setupList(this.list);

        this.ajaxUrl = Cuztom.ajax_url;

        this.ajaxPayload = {
            action: null,
            security: Cuztom.wp_nonce,
            cuztom: {
                box:   'meetaa',
                field: this.id,
                count: this.list.length + 1,
            }
        }
    },

    methods: {

        setupList: function() {
            this.list = [];
        },

        addItem: function() {
            var vm = this;

            this.ajaxPayload.action = 'cuztom_add_repeatable_item';

            jQuery.post(this.ajaxUrl, this.ajaxPayload, function(response) {
                var response = JSON.parse(response);

                if(response.status) {
                    vm.list.push(response.item);

                    cuztomUI(document);
                } else {
                    alert(response.message);
                }
            });
        }

    }

});