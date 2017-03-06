
if($('.v-cuztom').length) {
    new Vue({

        el: '.v-cuztom',

        data: {},

        methods: {

            reload: function() {
                this.reloadVue();

                this.reloadCuztomUI();
            },

            reloadVue: function() {
                // this.$forceUpdate();
            },

            reloadCuztomUI: function() {
                Vue.nextTick(function () {
                    cuztomUI(document);
                });
            }

        }

    });
}