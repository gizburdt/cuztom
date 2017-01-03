
Vue.component('v-cuztom-repeatable', {

    mixins: [vCuztomSortable],

    methods: {

        setupList: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_setup_repeatable_list',
                success: function(response) {
                    vm.$set('list', response.content);

                    vm.$set('loading', false);

                    vm.cuztomUI();
                }
            }, {
                values: this.values
            });
        },

        addItem: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_add_repeatable_item',
                success: function(response) {
                    vm.list.push(response.content);

                    vm.$set('loading', false);

                    vm.cuztomUI();
                }
            }, {
                count: this.list.length,
            });
        },

    }

});