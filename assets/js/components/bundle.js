
Vue.component('v-cuztom-bundle', {

    mixins: [vCuztomSortable],

    methods: {

        setupList: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_setup_bundle_list',
                success: function(response) {
                    vm.$set('list', response.content);
                }
            }, {
                values: this.values
            });
        },

        addItem: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_add_bundle_item',
                success: function(response) {
                    vm.list.push(response.content);

                    cuztomUI(document);
                }
            }, {
                count: this.list.length,
            });
        },

    }

});