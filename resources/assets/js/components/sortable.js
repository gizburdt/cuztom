
var vCuztomSortable = {

    props: {
        id: String,
        box: String,
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
                    alert(response.message);
                }
            }, options);

            var params = jQuery.extend({
                box: this.box,
                field: this.id,
            }, params);

            var payload = {
                action: options.action,
                security: Cuztom.wp_nonce,
                cuztom: params
            };

            jQuery.post(Cuztom.ajax_url, payload, function(response) {
                var response = JSON.parse(response);

                if(response.status) {
                    return options.success(response);
                }

                return options.fail(response);
            });
        },

    }

}