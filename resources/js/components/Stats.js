import $ from 'jquery';
import Globals from '../helpers/Globals';

const { $body } = Globals;

export default {
    init() {
        $body.on('click', '.js-stats-tab', e => this.toggleTab(e));
    },

    toggleTab(e) {
        const $curr = $(e.currentTarget);

        $curr.parent().toggleClass('open');
        $curr.parent().find('.js-table-wrapper').slideToggle(300);
    },
};
