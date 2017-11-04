
(function() {
    var vCuztom = $('.v-cuztom')

    if(vCuztom.length) {

        vCuztom.each(function(index, element){

            new Vue({

                el: element,

                data: {},

                methods: {

                    reload: function() {
                        // this.reloadVue();

                        this.reloadCuztomUI();
                    },

                    reloadVue: function() {
                        this.$forceUpdate();
                    },

                    reloadCuztomUI: function() {
                        Vue.nextTick(function () {
                            cuztomUI(document);
                        });
                    }

                }

            });

        });

    }

})();