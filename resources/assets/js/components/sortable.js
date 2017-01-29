
var vCuztomSortable = {

    props: {
        id: String,
        box: String,
        object: String
    },

    data: function() {
        return {
            list: [],
            loading: true,
            values: []
        }
    },

    ready: function() {
        this.setupList();
    },

    methods: {

        removeItem: function(item) {
            this.list.$remove(item);

            this.$set('loading', false);
        },

        postAjax: function (options, params) {
            var vm = this;

            var options = jQuery.extend({
                fail: function(response) {
                    alert(response.content);

                    vm.$set('loading', false);
                }
            }, options);

            var params = jQuery.extend({
                box: this.box,
                field: this.id,
                object: this.object
            }, params);

            var payload = {
                action: options.action,
                security: Cuztom.wpNonce,
                cuztom: params
            };

            jQuery.post(Cuztom.ajaxUrl, payload, function(response) {
                var response = JSON.parse(response);

                if(response.status) {
                    return options.success(response);
                }

                return options.fail(response);
            });
        },

    }

}