(function() {
    var shortChild = Vue.component('short-child', {
        template: '<div class="child">' +
                    '{{ result }}' +
                    '<button class="bg-blue py-2 px-4 rounded text-white" @click="submit">Change Test</button> ' +
                '</div>',
        props: ['atts'],
        data: function () {
            return {
                result: this.atts.name
            }
        },
        methods: {
            submit: function () {
                var queryString = '?action=get_data'
                fetch(window.ajaxUrl + queryString)
                    .then(function(response) { return response.json()})
                    .then(function(json) { this.result = json }.bind(this))
            }
        }
    })


    var element = document.querySelector('[data-vue-atts]')
    var atts = JSON.parse(element.getAttribute('data-vue-atts'))

    var vm = new Vue({
        el: element,
        data: {
            testData: 'Hello world'
        },
        template: '<div class="container">' +
                        '<short-child :atts="atts"/>' +
                    '</div>',
        created: function() {
            this.atts = atts
        }
    })
})();
