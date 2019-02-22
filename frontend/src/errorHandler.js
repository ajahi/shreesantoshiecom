import axios from 'axios';
import router from './router';



function errorResponseHandler(error) {
    if(error.response.status === 403) {
        router.push({name:'AccessDenied'});
    }
    return Promise.reject(error);


}



export default errorResponseHandler;