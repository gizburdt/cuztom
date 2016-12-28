
Vue.component('v-cuztom-repeatable', {

    mixins: [vCuztomSortable],

    methods: {

        setupList: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_setup_repeatable_list',
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
                action: 'cuztom_add_repeatable_item',
                success: function(response) {
                    vm.list.push(response.content);

                    Vue.nextTick(function () {
                        cuztomUI(document);
                    });
                }
            }, {
                count: this.list.length,
            });
        },

    }

});