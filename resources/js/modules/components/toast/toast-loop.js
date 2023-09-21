export default (toast) => ({
    toast :  toast,
    show : false,
    init() {
        this.$nextTick(() => this.show = true);

        setTimeout(() => this.hide(), this.toast.timeout * 1000);
    },
    accept(toast) {
        let params = toast.options.confirm.params ?? null;

        this.$dispatch(toast.options.confirm.event, params.constructor !== Array ? [params] : [...params]);

        this.hide();
    },
    reject(toast) {
        let params = toast.options.cancel.params ?? null;

        this.$dispatch(toast.options.cancel.event, params.constructor !== Array ? [params] : [...params]);

        this.hide();
    },
    hide() {
        this.show = false;

        setTimeout(() => this.remove(this.toast), this.toast.timeout);
    }
})
