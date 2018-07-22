
const Helpers = {
    install(Vue, options) {
        Vue.buttonLoaderOnEvent = function (e) {
            let classes = e.target.attributes.class.value;
            e.target.attributes.class.value = classes +' loader';
            return classes;
        },
        Vue.buttonLoaderRemove = function(e, classes) {
            e.target.attributes.class.value = classes;
        },
        Vue.randomArrayValue = function (array) {
            return array[Math.floor(Math.random() * array.length)];
        },
        Vue.scrollToHash = function (id) {
            location.hash = "#" + id;
        },
        Vue.scrollToElement = function(id) {
            var topPos = document.getElementById(id).offsetTop;
            document.getElementById(id).parentNode.scrollTop = topPos-10;
        }
    }
}
export default Helpers;