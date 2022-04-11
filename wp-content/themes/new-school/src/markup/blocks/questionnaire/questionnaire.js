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

    const $questionTextScreen = $wrapper.querySelector(`[${dataPrefix}-text-about-questionnaire]`);
    const $questionItemsScreen = $wrapper.querySelector(`[${dataPrefix}-items]`);
    const questionItems = $wrapper.querySelectorAll(`[${dataPrefix}-item]`);

    const $about = $wrapper.querySelector(`[${dataPrefix}-about]`);
    const aboutQuestions = $wrapper.querySelectorAll(`[${dataPrefix}-about-question-wrapper]`);

    const $registerScreen = $wrapper.querySelector(`[${dataPrefix}-register]`);
    const $resultScreen = $wrapper.querySelector(`[${dataPrefix}-result]`);
    const $sendResultButton = $wrapper.querySelector(`[${dataPrefix}-send-result-button]`);


    let userId;
    let answers = [];
    let about = [];

    init();

    function init() {
        addListeners();

        questionsHandler();

        aboutHandler();
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

        $sendResultButton.addEventListener('click', () => {
            if ($sendResultButton.classList.contains('questionnaire__button--disabled')) {
                return;
            }

            sendAnswers();
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
            //
            // // TODO: Удалить с продакшена!
            // $sendSmsInput.value = response.data.data[1];

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
            if (response.data.success) {
                $sendParentCodeError.classList.add(hiddenClass);
                showScreen();
                $registerScreen.classList.add(hiddenClass);
                $questionTextScreen.classList.add(hiddenClass);
                $questionItemsScreen.classList.remove(hiddenClass);
            } else {
                $sendParentCodeError.classList.remove(hiddenClass);
                $sendParentCodeError.textContent = response.data.data[0].message;
            }
        }).catch((error) => {
            console.error(error);
            alert(error);
        });
    }

    function sendAnswers() {
        const url = '/wp-admin/admin-ajax.php';

        const data = new URLSearchParams();
        data.append('action', 'ajax_get_answers');
        data.append('data', JSON.stringify({
            about,
            answers,
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
                $resultScreen.classList.remove(hiddenClass);
                $questionItemsScreen.classList.add(hiddenClass);
            } else {
                alert(response.data);
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

    function aboutHandler() {
        let checkResultArray = [];

        for (let index = 0; index < aboutQuestions.length; index++) {
            const $item = aboutQuestions[index];

            checkResultArray[index] = false;

            let $inputs = $item.querySelectorAll('input');

            for (let $input of $inputs) {
                if ($input.type === 'checkbox') {
                    $input.addEventListener('change', (event) => {
                        for (let $input of $inputs) {
                            $input.checked = false;

                            if ($input.closest('.questionnaire__about-question-item-inner').querySelector('input.input')) {
                                $input.closest('.questionnaire__about-question-item-inner').querySelector('input.input').setAttribute('disabled', true);
                            }
                        }

                        event.target.checked = true;

                        if (event.target.closest('.questionnaire__about-question-item-inner').querySelector('input.input')) {
                            event.target.closest('.questionnaire__about-question-item-inner').querySelector('input.input').removeAttribute('disabled', true);
                        }


                        getInfo();
                        checkButton();
                    });
                } else {
                    $input.addEventListener('change', (event) => {
                        getInfo();
                        checkButton();
                    });
                }
            }
        }

        function getInfo() {
            for (let index = 0; index < aboutQuestions.length; index++) {
                const $item = aboutQuestions[index];
                let title = $item.querySelector('.questionnaire__about-question-title').innerText;

                let aboutAnswersObject = {
                    answers: [],
                    title
                };

                let $inputs = $item.querySelectorAll('input');

                for (let $input of $inputs) {
                    if ($input.type === 'checkbox') {
                        if ($input.checked) {
                            aboutAnswersObject.answers.push($input.closest('.checkbox').querySelector('.checkbox__text').innerText);

                            if ($input.closest('.questionnaire__about-question-item-inner').querySelector('input.input')) {
                                aboutAnswersObject.answers.push($input.closest('.questionnaire__about-question-item-inner').querySelector('input.input').value);
                            }
                        }
                    }
                }

                about[index] = aboutAnswersObject;
            }
        }

        function checkButton() {
            for (let index = 0; index < aboutQuestions.length; index++) {
                const $item = aboutQuestions[index];

                let $inputs = $item.querySelectorAll('input');

                checkResultArray[index] = false;

                for (let $input of $inputs) {
                    if ($input.type === 'checkbox') {
                        if ($input.checked) {

                            if ($input.closest('.questionnaire__about-question-item-inner').querySelector('input.input')) {
                                if ($input.closest('.questionnaire__about-question-item-inner').querySelector('input.input').value !== '') {
                                    checkResultArray[index] = true;
                                }
                            } else {
                                checkResultArray[index] = true;
                            }
                        }
                    }
                }
            }

            if (checkResultArray.indexOf(false) === -1) {
                $sendResultButton.classList.remove('questionnaire__button--disabled');
            } else {
                $sendResultButton.classList.add('questionnaire__button--disabled');
            }
        }
    }

    function questionsHandler() {

        for (let index = 0; index < questionItems.length; index++) {
            let $item = questionItems[index];

            const max = +$item.dataset.questionnaireItemMax;
            const inputs = $item.querySelectorAll('input');
            const $own = $item.querySelector(`[${dataPrefix}-own-answer]`);
            const $ownText = $item.querySelector('textarea');

            let $prevChange;

            let answersObject = {
                title: $item.querySelector(`[${dataPrefix}-item-title]`).innerText,
                answers: []
            };

            answers[index] = answersObject;

            for (let $input of inputs) {
                $input.addEventListener('change', (event) => {
                    let checkedCount = 0;

                    for (let $input of inputs) {
                        if ($input.checked) {
                            checkedCount += 1;
                        }
                    }

                    if (checkedCount > max) {
                        if ($prevChange) {
                            $prevChange.checked = false;
                        } else {
                            event.target.checked = false;
                        }
                    }

                    if (checkedCount === 0) {
                        $next.classList.add('questionnaire__button--disabled');
                    } else {
                        $next.classList.remove('questionnaire__button--disabled');
                    }


                    $prevChange = event.target;

                    if ($own.checked) {
                        $ownText.removeAttribute('disabled');
                    } else {
                        $ownText.setAttribute('disabled', true);
                    }

                    setAnswers();
                });
            }

            $ownText.addEventListener('change', setAnswers);

            function setAnswers() {
                let itemAnswers = [];

                for (let $input of inputs) {
                    if ($input.checked) {
                        if ($input.closest('.questionnaire__check-box-block')) {
                            itemAnswers.push($input.closest('.questionnaire__check-box-block').querySelector('.checkbox__text').innerText);
                        } else {
                            itemAnswers.push($input.closest('.questionnaire__check-box-text-block').querySelector('textarea').value);
                        }
                    }
                }

                answersObject.answers = itemAnswers;

                answers[index] = answersObject;
            }

            const $prev = $item.querySelector(`[${dataPrefix}-item-button-prev]`);
            const $next = $item.querySelector(`[${dataPrefix}-item-button-next]`);

            if ($prev) {
                $prev.addEventListener('click', () => {
                    showItem(index - 1);
                });
            }

            $next.addEventListener('click', () => {
                if ($next.classList.contains('questionnaire__button--disabled')) {
                    return;
                }

                showItem(index + 1);
            });

        }

        function showItem(targetIndex) {
            for (let index = 0; index < questionItems.length; index++) {
                let $item = questionItems[index];

                $item.classList.add(hiddenClass);
            }

            if (targetIndex === questionItems.length) {
                $about.classList.remove(hiddenClass);
            } else {
                questionItems[targetIndex].classList.remove(hiddenClass);
            }
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
