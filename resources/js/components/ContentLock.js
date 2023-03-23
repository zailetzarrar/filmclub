import Globals from '../helpers/Globals';

const { breakpoint } = Globals;

export default {
    lock() {
        this.scrollPosition = window.pageYOffset;

        document.body.style.top = `${this.scrollPosition}px`;
        document.body.classList.add('content-lock');

        if (window.innerWidth < breakpoint.medium) window.scrollTo(0, 0);
    },

    unlock() {
        const scrollOffset = Math.abs(parseFloat(this.scrollPosition));

        document.body.style.removeProperty('top');
        document.body.classList.remove('content-lock');

        window.scrollTo(0, scrollOffset);
    },
};
