
const Helpers = {
    install(Vue, options) {
        Vue.buttonLoaderOnEvent = function (e) {
            // console.log('Here');
            let classes = e.target.attributes.class.value;
            e.target.attributes.class.value = classes +' loader';
            // console.log(classes);
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
        },
        Vue.scrollToAndGlow = function(name, id) {
            setTimeout(function() {
                Vue.scrollToElement(name);
                store.state.Model.animationClasses["glitter-dentix"].push(id);
                setTimeout(function() {
                    store.state.Model.animationClasses["glitter-dentix"] = []; 
                },3000); 
            },1000);
        }
    }
}
export default Helpers;