const { setId } = require('../set-id/set-id');

export class Validation {

    /* Example options
    {
        formClass:'form-check',     // String
        $form:document.getElementsByClassName(this.formClass)[0],       // node element
        formFieldClass:'form-check__field',     // String
        $formFields:document.getElementsByClassName('form-check__field'),       // html collection
        errorWrapperClass:'form-check__error',     // String
        errorShowClass:'form-check__error--show',     // String
        buttonClass:'form-check__button',     // String
        $button:document.getElementsByClassName(this.formClass)[0],       // node element
        buttonDisabledClass:'form-check__button--disabled',     // String
    }
     */

    constructor(options) {
        this.formClass = options && options.formClass ?
            options.formClass :
            'form-check';
        this.$form = options && options.$form ?
            options.$form :
            document.getElementsByClassName(this.formClass)[0];

        this.formFieldClass = options && options.formClass ?
            options.formClass :
            'form-check__field';
        this.$formFields = options && options.$formFields ?
            options.$formFields :
            this.$form.getElementsByClassName(this.formFieldClass);
        this.errorWrapperClass = options && options.errorWrapperClass ?
            options.errorWrapperClass :
            'form-check__error';
        this.errorShowClass = options && options.errorShowClass ?
            options.errorShowClass :
            'form-check__error--show';
        this.inputFocusClass = options && options.inputFocusClass ?
            options.inputFocusClass :
            'form-check__field--focus';
        this.buttonClass = options && options.buttonClass ?
            options.buttonClass :
            'form-check__button';
        this.$buttons = options && options.$buttons ?
            options.$buttons :
            this.$form.getElementsByClassName(this.buttonClass);
        this.buttonDisabledClass = options && options.buttonDisabledClass ?
            options.buttonDisabledClass :
            'form-check__button--disabled';

        this.rulesList = new Map([
            [
                'input-empty',
                {
                    checkEvents: [
                        'change',
                        'input'
                    ],
                    errorMessage: 'Обязательное поле',
                    functionCheck: this.validateInputEmpty.bind(this),
                }
            ],
            [
                'min-count-symbol',
                {
                    checkEvents: [
                        'change',
                        'input'
                    ],
                    errorMessage: 'Минимум символов: ',
                    functionCheck: this.validateMinCountSymbols.bind(this),
                }
            ],
            [
                'phone-with-mask',
                {
                    checkEvents: [
                        'change',
                        'input'
                    ],
                    errorMessage: 'Некорректный телефон',
                    functionCheck: this.validatePhoneWithMak.bind(this),
                }
            ],
            [
                'count-symbol',
                {
                    checkEvents: [
                        'change',
                        'input'
                    ],
                    errorMessage: 'Необходимо символов: ',
                    functionCheck: this.validateCountSymbols.bind(this),
                }
            ],
            [
                'select-empty',
                {
                    checkEvents: ['change'],
                    errorMessage: 'Выберите значение',
                    functionCheck: this.validateSelect.bind(this),
                }
            ],
        ]);
    }

    init() {
        this.fieldsArray = null;
        this.fieldsArray = this.createFieldsArray();
        this.fieldListeners = [];
        this.buttonListeners = [];
        this.focusinInputListeners = [];
        this.focusoutInputListeners = [];
        this.handleAllListeners(true);
        this.createErrorWrappers();
        this.validationForm(false);
    }

    // Создание объекта с полями
    createFieldsArray() {
        let fieldsArray = [];

        for (let $formField of this.$formFields) {

            // Собираем дата атрибуты для определения типа проверки и элемента
            let elem = $formField.dataset.elem;
            let rules = $formField.dataset.rule.split(', ');

            // Определяем элемент, который будем проверять
            let $elem;

            if (elem !== 'self-dispatch') {
                $elem = $formField.querySelector(elem);
            } else {
                $elem = $formField;
            }

            let fieldObject = {
                elem: elem,
                rules: rules,
                $elem: $elem,
                $field: $formField,
            };

            fieldsArray.push(fieldObject);
        }

        return fieldsArray;
    }

    // Валидация всей формы
    validationForm(showError) {
        let errors = [];

        for (let field of this.fieldsArray) {
            let error = this.validateField(field, showError);

            if (error !== false) {
                errors.push(error);
            }
        }

        if (errors.length > 0) {
            for (let $button of this.$buttons) {
                $button.classList.add(this.buttonDisabledClass);
            }
        } else {
            for (let $button of this.$buttons) {
                $button.classList.remove(this.buttonDisabledClass);
            }
        }
    }

    // Валидация одного поля
    validateField(field, showError) {
        let errors = [];

        // Выполняем последовательно проверки
        for (let rule of field.rules) {
            let errorMessage = this.rulesList.get(rule).errorMessage;

            let validateResult = this.rulesList.get(rule)
                .functionCheck(field.$field, field.$elem, errorMessage);

            if (!validateResult.validate) {
                errors.push(validateResult);
            }
        }

        // Определяем наиболее приоритетную ошибку и оставляем в массиве только ее
        if (errors.length > 0) {
            errors.sort((a, b) => {
                return a.priority < b.priority ?
                    1 :
                    -1;
            });

            errors = errors[0];
        } else {
            field.$field.classList.remove(this.errorShowClass);
            return false;
        }

        field.$error.textContent = errors.message;

        if (showError) {
            field.$field.classList.add(this.errorShowClass);
        }

        return errors;
    }

    // Создание полей с ошибками
    createErrorWrappers() {
        for (let field of this.fieldsArray) {
            let template = `<div class="${this.errorWrapperClass}"></div>`;

            if (field.$field.getElementsByClassName(this.errorWrapperClass).length > 0) {
                field.$field.insertAdjacentHTML('beforeEnd', template);
            }

            field.$field.insertAdjacentHTML('beforeEnd', template);
            field.$error = field.$field.getElementsByClassName(this.errorWrapperClass)[0];
        }
    }

    // Удаление полей с ошибками
    removeErrorWrappers() {
        for (let field of this.fieldsArray) {
            field.$field.classList.remove(this.errorShowClass);
            let $errorWrapper = field.$field.getElementsByClassName(this.errorWrapperClass)[0];
            $errorWrapper.remove();
        }
    }

    // Создание событий
    handleAllListeners(add) {
        let index = 0;
        let fieldIndex = 0;

        for (let field of this.fieldsArray) {
            for (let rule of field.rules) {
                let eventChecks = this.rulesList.get(rule).checkEvents;
                this.fieldListeners.push(this.addFieldEvent.bind(this, field));

                for (let eventCheck of eventChecks) {
                    if (add) {
                        field.$elem.addEventListener(eventCheck, this.fieldListeners[index]);
                    } else {
                        field.$elem.removeEventListener(eventCheck, this.fieldListeners[index]);
                    }
                }
                index++;
            }

            if (field.elem === 'input' || field.elem === 'textarea') {
                this.focusinInputListeners.push(this.addInputFocusinEvent.bind(this, field));
                this.focusoutInputListeners.push(this.addInputFocusoutEvent.bind(this, field));

                if (add) {
                    field.$elem.addEventListener('focusin', this.focusinInputListeners[fieldIndex]);
                    field.$elem.addEventListener('focusout', this.focusoutInputListeners[fieldIndex]);
                } else {
                    field.$elem.removeEventListener('focusin', this.focusinInputListeners[fieldIndex]);
                    field.$elem.removeEventListener('focusout', this.focusoutInputListeners[fieldIndex]);
                }
            } else {
                this.focusinInputListeners.push('');
                this.focusoutInputListeners.push('');
            }

            fieldIndex++;
        }

        this.buttonListeners.push(this.addButtonEvent.bind(this));

        if (add) {
            for (let $button of this.$buttons) {
                $button.addEventListener('click', this.buttonListeners[0]);
            }
        } else {
            for (let $button of this.$buttons) {
                $button.removeEventListener('click', this.buttonListeners[0]);
            }
        }
    }

    addFieldEvent(field) {
        this.validateField(field, true);
        this.validationForm(false);
    }

    addInputFocusinEvent(field) {
        field.$field.classList.add(this.inputFocusClass);
    }

    addInputFocusoutEvent(field) {
        field.$field.classList.remove(this.inputFocusClass);
    }

    addButtonEvent(event) {
        this.validationForm(true);

        for (let $button of this.$buttons) {
            if ($button.classList.contains(this.buttonDisabledClass)) {
                event.preventDefault();
            }
        }
    }

    // Проверка пустого поля
    validateInputEmpty($field, $elem, errorMessage) {
        let val = $elem.value;
        let validate = val !== '';
        let priority = 100;

        return {
            validate: validate,
            message: errorMessage,
            priority: priority
        };
    }

    // Проверка минимального количества символов
    validateMinCountSymbols($field, $elem, errorMessage) {
        let val = $elem.value;
        let minCount = parseInt($field.dataset.minCountSymbol);
        let validate = val.length >= minCount;
        let message = errorMessage + minCount;
        let priority = 200;

        return {
            validate: validate,
            message: message,
            priority: priority
        };
    }

    // Проверка минимального количества символов
    validateCountSymbols($field, $elem, errorMessage) {
        let val = $elem.value;
        let count = parseInt($field.dataset.countSymbol);
        let validate = val.length === count;
        let message = errorMessage + count;
        let priority = 200;

        return {
            validate: validate,
            message: message,
            priority: priority
        };
    }

    // Проверка телефона
    validatePhoneWithMak($field, $elem, errorMessage) {
        let val = $elem.value;
        let validate = val.length > 15;
        let message = errorMessage;
        let priority = 200;

        return {
            validate: validate,
            message: message,
            priority: priority
        };
    }

    // Проверка селекта
    validateSelect($field, $elem, errorMessage) {
        let val = $elem.value;
        let validate = val !== 'default' && val !== '';

        let message = errorMessage;
        let priority = 200;

        return {
            validate: validate,
            message: message,
            priority: priority
        };
    }

    // Метод обновления формы
    refresh() {
        this.handleAllListeners(false);
        this.removeErrorWrappers();
        this.init();
    }
}

let forms = Array.from(document.querySelectorAll('.form-check'));
window.formsArray = new Map();

if (forms.length > 0) {
    for (let index = 0; index < forms.length; index++) {
        let $form = forms[index];
        let id = setId($form);

        window.formsArray.set(id, new Validation({ $form: $form }));
        window.formsArray.get(id)
            .init();
    }
}




