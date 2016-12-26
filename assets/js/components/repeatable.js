
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
        this.list = this.list ? this.list : [];

        this.sortableList = jQuery(this.$el).find('.js-cuztom-sortable-list');

        this.ajaxUrl = Cuztom.ajax_url;

        this.ajaxPayload = {
            action: null,
            security: Cuztom.wp_nonce,
            cuztom: {
                box:   'meetaa',
                field: this.id,
                count: this.list.length++,
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

                    vm.sortableList.append(response.item);

                    cuztomUI(document);
                } else {
                    alert(response.message);
                }
            });
        }

    }

});