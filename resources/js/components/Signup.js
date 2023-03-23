import $ from 'jquery';
import Globals from '../helpers/Globals';
import Pick from './Pick';

const { $body } = Globals;

export default {
    init() {
        $body.on('submit', '.js-signup-one', e => this.handleInputs(e));
        $body.on('click', '.js-next-step', e => this.nextStep(e));
        $body.on('click', '.js-progress', e => this.goToStep(e));
        $body.on('click', '.js-clipboard', () => this.handleClipboardTooltip());
    },

    validate() {
        const $name = $('.js-data-name');
        if ($name.val().length) return true;
        return false;
    },

    handleInputs(e) {
        e.preventDefault();
        const $step = $('.js-step');
        const $step2 = $('.js-step-two');
        const valid = this.validate();

        if (valid) {
            $step.removeClass('active');
            $step2.addClass('active');
        }
    },

    goToStep(e) {
        const $curr = $(e.currentTarget);
        const $step = $('.js-step');
        const $step1 = $('.js-step-one');
        const $step2 = $('.js-step-two');
        const $step3 = $('.js-step-three');

        if ($curr.hasClass('js-progress-one')) {
            $step.removeClass('active');
            $step1.addClass('active');
        } else if ($curr.hasClass('js-progress-two')) {
            $step.removeClass('active');
            $step2.addClass('active');
        } else if ($curr.hasClass('js-progress-three')) {
            $step.removeClass('active');
            $step3.addClass('active');
        }
    },

    nextStep(e) {
        const $curr = $(e.currentTarget);
        const $step = $('.js-step');
        const $step2 = $('.js-step-two');
        const $step3 = $('.js-step-three');

        if ($curr.data('step') === 1) {
            $step.removeClass('active');
            $step2.addClass('active');
        } else if ($curr.data('step') === 2) {
            Pick.closeFilmInfo();
            $step.removeClass('active');
            $step3.addClass('active');
        }
    },

    handleClipboardTooltip() {
        $('.js-shareable-link').select();
        document.execCommand('copy');
        $('.js-clipboard-tooltip').text('Link copied!');
    },
};
