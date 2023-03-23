import Dashboard from './Dashboard';
import Pick from './Pick';
import Signup from './Signup';
import Stats from './Stats';

export default () => {
    Dashboard.init();
    Pick.init();
    Signup.init();
    Stats.init();
};
