export const axios = require('axios');

const $questionnaire = document.querySelector('.questionnaire');

if ($questionnaire) {
    questionnaire($questionnaire);
}

export function questionnaire($wrapper) {
    const classPrefix = 'questionnaire';
    const dataPrefix = 'data-questionnaire';
    const hiddenClass = `${classPrefix}__hidden`;

    const authScreens = $wrapper.querySelectorAll(`[${dataPrefix}-auth-screen]`);

    const $getSmsScreen = $wrapper.querySelector(`[${dataPrefix}-get-sms-screen]`);
    const $getSmsInput = $wrapper.querySelector(`[${dataPrefix}-get-sms-input]`);
    const $getSmsButton = $wrapper.querySelector(`[${dataPrefix}-get-sms-button]`);

    const $sendSmsScreen = $wrapper.querySelector(`[${dataPrefix}-send-sms-code-screen]`);
    const $sendSmsInput = $wrapper.querySelector(`[${dataPrefix}-send-sms-code-input]`);
    const $sendSmsButton = $wrapper.querySelector(`[${dataPrefix}-send-sms-code-button]`);
    const $sendSmsError = $wrapper.querySelector(`[${dataPrefix}-send-sms-code-error]`);
    const $backToGetButton = $wrapper.querySelector(`[${dataPrefix}-back-to-get-sms-code]`);

    const $sendParentCodeScreen = $wrapper.querySelector(`[${dataPrefix}-send-parent-code-screen]`);
    const $sendParentCodeInputCode = $wrapper.querySelector(`[${dataPrefix}-send-parent-code-input]`);
    const $sendParentCodeInputFname = $wrapper.querySelector(`[${dataPrefix}-send-parent-code-fname]`);
    const $sendParentCodeInputMnane = $wrapper.querySelector(`[${dataPrefix}-send-parent-code-mname]`);
    const $sendParentCodeButton = $wrapper.querySelector(`[${dataPrefix}-send-parent-code-button]`);
    const $sendParentCodeError = $wrapper.querySelector(`[${dataPrefix}-send-parent-code-error]`);


    let userId;

    init();

    function init() {
        addListeners();
    }

    function addListeners() {
        $getSmsButton.addEventListener('click', () => {
            if (checkButtonDisabled($getSmsButton)) {
                return;
            }

            getSms();
        });

        $sendSmsButton.addEventListener('click', () => {
            if (checkButtonDisabled($sendSmsButton)) {
                return;
            }

            sendSms();
        });

        $sendParentCodeButton.addEventListener('click', () => {
            if (checkButtonDisabled($sendParentCodeButton)) {
                return;
            }

            sendParentCode();
        });

        $backToGetButton.addEventListener('click', () => {
            showScreen($getSmsScreen);
        });
    }

    function getSms() {
        const url = '/wp-admin/admin-ajax.php';

        const data = new URLSearchParams();
        data.append('action', 'ajax_parent_auth');
        data.append('data', $getSmsInput.value);

        const options = {
            method: 'POST',
            headers: {'content-type': 'application/x-www-form-urlencoded'},
            data: data,
            url,
        };

        axios(options).then((response) => {
            userId = response.data.data[0];

            // TODO: Удалить с продакшена!
            $sendSmsInput.value = response.data.data[1];

            showScreen($sendSmsScreen);
        }).catch((error) => {
            console.error(error);
        });
    }

    function sendSms() {
        const url = '/wp-admin/admin-ajax.php';

        const data = new URLSearchParams();
        data.append('action', 'ajax_check_pass');
        data.append('data', JSON.stringify({
            password: $sendSmsInput.value,
            userId
        }));

        const options = {
            method: 'POST',
            headers: {'content-type': 'application/x-www-form-urlencoded'},
            data: data,
            url,
        };

        axios(options).then((response) => {
            if (response.data.success) {
                $sendSmsError.classList.add(hiddenClass);
                showScreen($sendParentCodeScreen);
            } else {
                $sendSmsError.classList.remove(hiddenClass);
            }
        }).catch((error) => {
            console.error(error);
            alert(error);
        });
    }

    function sendParentCode() {
        const url = '/wp-admin/admin-ajax.php';

        const data = new URLSearchParams();
        data.append('action', 'ajax_check_parent_code');
        data.append('data', JSON.stringify({
            parentCode: $sendParentCodeInputCode.value,
            fname: $sendParentCodeInputFname.value,
            mname: $sendParentCodeInputMnane.value,
            userId
        }));

        const options = {
            method: 'POST',
            headers: {'content-type': 'application/x-www-form-urlencoded'},
            data: data,
            url,
        };

        axios(options).then((response) => {
            console.log(response.data);


            if (response.data.success) {
                $sendParentCodeError.classList.add(hiddenClass);
                // showScreen();
            } else {
                $sendParentCodeError.classList.remove(hiddenClass);
                $sendParentCodeError.textContent = response.data.data[0].message;
            }
        }).catch((error) => {
            console.error(error);
            alert(error);
        });
    }

    function showScreen($screen) {
        $sendSmsError.classList.add(hiddenClass);
        $sendSmsError.classList.add(hiddenClass);

        for (let $authScreen of authScreens) {
            $authScreen.classList.add(hiddenClass);
        }

        if ($screen) {
            $screen.classList.remove(hiddenClass);
        }
    }
}

export function checkButtonDisabled($button) {
    if ($button.classList.contains('form-check__button--disabled')) {
        return true;
    } else {
        return false;
    }
}
