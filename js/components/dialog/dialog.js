import {dispatchEvent, overflow} from '../../helpers';

export default (texts) => ({
  show: false,
  dialog: {},
  text: {
    ok: texts.ok,
    confirm: texts.confirm,
    cancel: texts.cancel,
  },
  init() {
    this.$watch('show', (value) => overflow(value, 'dialog'));
  },
  /**
   * @param dialog {Object}
   * @return {void}
   */
  add(dialog) {
    this.show = true;

    this.dialog = dialog;
  },
  /**
   * @param dismissed {Boolean}
   * @return {void}
   */
  remove(dismissed = false) {
    this.show = false;

    if (!dismissed) return;

    dispatchEvent('dialog:dismissed', this.dialog, false);
  },
  /**
   * @param dialog {Object}
   * @param element {HTMLElement}
   * @return {void}
   */
  accept(dialog, element) {
    dispatchEvent('dialog:accepted', dialog, false);

    if (dialog.type !== 'question') {
      return this.remove();
    }

    const params = dialog.options.confirm.params ?? null;

    setTimeout(() => {
      Livewire.find(dialog.component)
          .call(dialog.options.confirm.method, params?.constructor !== Array ? params : [...params]);

      // This is a little trick to prevent the element from being
      // focused if there is another dialog displayed sequentially.
      element.blur();
    }, 100);

    this.remove();
  },
  /**
   * @param dialog {Object}
   * @param element {HTMLElement}
   * @return {void}
   */
  reject(dialog, element) {
    dispatchEvent('dialog:rejected', dialog, false);

    if (dialog.type !== 'question') {
      return this.remove();
    }

    if (dialog.options.cancel.method) {
      const params = dialog.options.cancel.params ?? null;

      setTimeout(() => {
        const method = dialog.options.cancel.method;

        if (method) {
          Livewire.find(dialog.component)
              .call(method, params?.constructor !== Array ? params : [...params]);
        }

        // This is a little trick to prevent the element from being
        // focused if there is another dialog displayed sequentially.
        element.blur();
      }, 100);
    }

    this.remove();
  },
});
