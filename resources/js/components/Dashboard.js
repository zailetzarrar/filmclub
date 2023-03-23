import $ from 'jquery';
import Globals from '../helpers/Globals';

const { $body } = Globals;

export default {
    init() {
        $body.on('click', '.js-watch-toggle', () => this.showRatingBlock());
        $body.on('click', '.js-close-rating', () => this.closeRatingBlock());
    },

    showRatingBlock() {
        const $pickBlock = $('.js-pick-block');
        const $ratingBlock = $('.js-rating-block');

        $pickBlock.hide();
        $ratingBlock.addClass('active');
    },

    closeRatingBlock() {
        const $pickBlock = $('.js-pick-block');
        const $ratingBlock = $('.js-rating-block');

        $pickBlock.show();
        $ratingBlock.removeClass('active');
    },
};
