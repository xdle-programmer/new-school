export const axios = require('axios');

const $parentAuth = document.querySelector('.parent-auth');

if ($parentAuth) {
    parentAuth($parentAuth);
}

export function parentAuth($wrapper) {
    const classPrefix = 'parent-auth';
    const dataPrefix = 'data-parent-auth';

    const $numberInput = $wrapper.querySelector(`[${dataPrefix}-number]`);
    const $getCodeButton = $wrapper.querySelector(`[${dataPrefix}-get-code]`);
    const $codeInput = $wrapper.querySelector(`[${dataPrefix}-code]`);
    const $sendCodeButton = $wrapper.querySelector(`[${dataPrefix}-send-code]`);

    let userId;

    init();

    function init() {
        addListeners();
    }

    function addListeners() {
        $getCodeButton.addEventListener('click', () => {
            const url = '/wp-admin/admin-ajax.php';

            const data = new URLSearchParams();
            data.append('action', 'ajax_parent_auth');
            data.append('data', $numberInput.value);

            const options = {
                method: 'POST',
                headers: {'content-type': 'application/x-www-form-urlencoded'},
                data: data,
                url,
            };

            axios(options).then((response) => {

                userId = response.data.data[0];
                console.log(response);
            }).catch((error) => {
                console.error(error);
                alert(error);
            });
        });

        $sendCodeButton.addEventListener('click', () => {
            const url = '/wp-admin/admin-ajax.php';

            const data = new URLSearchParams();
            data.append('action', 'ajax_check_pass');
            data.append('data', JSON.stringify({
                password: $codeInput.value,
                userId
            }));

            const options = {
                method: 'POST',
                headers: {'content-type': 'application/x-www-form-urlencoded'},
                data: data,
                url,
            };

            axios(options).then((response) => {
                console.log(response);

                // if (!response.data.success) {
                //     console.log(response.data);
                //
                //     let error = '';
                //
                //     for (let message of response.data.data) {
                //         error += ` ${message.message} `;
                //     }
                //
                //     alert(error);
                // } else {
                //     window.location.reload();
                // }
            }).catch((error) => {
                console.error(error);
                alert(error);
            });
        });
    }
}


