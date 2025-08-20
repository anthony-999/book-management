
import {useToast} from 'vue-toast-notification';

export function toastNotications() {
    
    const $toast = useToast();
    const success = (msg) => $toast.success(msg, { position: "bottom-right" });
    const error = (msg) => $toast.error(msg, { position: "bottom-right" });
    const info = (msg) => $toast.info(msg, { position: "bottom-right" });

    return {success, error, info};

}