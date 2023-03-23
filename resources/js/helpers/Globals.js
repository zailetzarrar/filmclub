import $ from 'jquery';

const Globals = {
    $body: $('body'),
    $html: $('html'),
    $window: $(window),
    $document: $(document),
    $main: $('.main'),
    isMobile: /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    isTablet: /iPad|tablet/i.test(navigator.userAgent),
    breakpoint: {
        small: 420,
        medium: 768,
        large: 1024,
        huge: 1440,
    },
};

export default Globals;
