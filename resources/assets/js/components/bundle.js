
Vue.component('v-cuztom-bundle', {

    mixins: [vCuztomSortable],

    methods: {

        setupList: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_setup_bundle_list',
                success: function(response) {
                    console.log(response.content);

                    vm.$set('list', response.content);

                    vm.$set('loading', false);

                    vm.$parent.reload();
                }
            }, {
                values: this.values
            });
        },

        addItem: function() {
            var vm = this;

            vm.$set('loading', true);

            this.postAjax({
                action: 'cuztom_add_bundle_item',
                success: function(response) {
                    console.log(response.content);

                    vm.list.push(response.content);

                    vm.$set('loading', false);

                    vm.$parent.reload();
                }
            }, {
                count: this.list.length,
                index: this.list.length
            });
        },

    }

});