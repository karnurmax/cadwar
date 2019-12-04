const arr = {
    toastMessage(msg, options) {
        this.$bvToast.toast(msg, options);
    }
};

export default function(Vue) {
    for (var k in arr) {
        if (arr.hasOwnProperty(k)) {
            Vue.prototype[k] = arr[k];
        }
    }
}
