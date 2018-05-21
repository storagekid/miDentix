
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
        }
    }
}
export default Helpers;