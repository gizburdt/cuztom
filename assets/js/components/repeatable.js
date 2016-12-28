
Vue.component('v-cuztom-repeatable', {

    mixins: [vCuztomSortable],

    methods: {

        setupList: function() {
            var vm = this;

            this.postAjax({
                action: 'cuztom_setup_repeatable_list',
                success: function(response) {
                    vm.$set('list', response.content);
                },
                fail: function(response) {
                    alert(response.message);
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

                    cuztomUI(document);
                },
                fail: function(response) {
                    alert(response.message);
                }
            }, {
                count: this.list.length,
            });
        },

    }

});