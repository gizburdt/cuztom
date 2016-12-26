
Vue.component('v-cuztom-repeatable', {

    props: [
        'id',
        'list'
    ],

    data: function() {
        return {
            id: null,
            list: [],
        }
    },

    ready: function() {
        if(! this.list) {
            this.list = [];
        }

        this.ajaxUrl = Cuztom.ajax_url;
        this.ajaxPayload = {
            action: null,
            security: Cuztom.wp_nonce,
            cuztom: {
                box:   'meetaa',
                field: this.id,
                count: this.list.length,
            }
        }
    },

    methods: {

        addItem: function() {
            var vm = this;

            this.ajaxPayload.action = 'cuztom_add_repeatable_item';

            jQuery.post(this.ajaxUrl, this.ajaxPayload, function(response) {
                var response = JSON.parse(response);

                if(response.status) {
                    vm.list.push(response.item);

                    // Re-init ui
                    cuztomUI(document);
                } else {
                    alert(response.message);
                }
            });

            console.log(this.list);
        }

    }

});