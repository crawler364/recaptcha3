class ReCaptcha3 {
    constructor(params) {
        this.siteKey = params.siteKey;
        this.position = params.position;
        this.action = params.action;
        this.signedParameters = params.signedParameters;
    }

    init(params) {
        this.captchaSid = params.captchaSid;
        this.captchaSidContainer = BX.findChild(BX(params.captchaId), {attribute: {'data-type': 'captcha-sid'}}, true, false);
        this.captchaWordContainer = BX.findChild(BX(params.captchaId), {attribute: {'data-type': 'captcha-word'}}, true, false);

        this.handler().then();
    }

    async handler() {
        let render = grecaptcha.render(BX('badge'), {
            'sitekey': this.siteKey,
            'badge': this.position,
            'size': 'invisible'
        });
        let token = await grecaptcha.execute(render, {
            action: this.action
        });
        let siteVerify = await BX.ajax.runComponentAction('wc:recaptcha3', 'siteVerify', {
            mode: 'ajax',
            data: {token: token},
            signedParameters: this.signedParameters,
        });
        console.log(siteVerify)

        if (siteVerify.status === 'success') {
            let processCaptcha = await BX.ajax.runComponentAction('wc:recaptcha3', 'processCaptcha', {
                mode: 'ajax',
                data: {
                    captchaSid: this.captchaSid,
                }
            });

            if (processCaptcha.status === 'success') {
                this.captchaWordContainer.value = processCaptcha.data.captchaWord;
            } else {
                processCaptcha.errors.forEach(function (error) {
                    console.error(error.message);
                });
            }
        } else {
            siteVerify.errors.forEach(function (error) {
                console.error(error.message);
            });
        }


    }

    error(num) {
        let error;
        switch (num) {
            case 0:
                error = `Ошибка #${num}. Не удалось получить sid капчи.`;
                break;
            case 1:
                error = `Ошибка #${num}. Не указан ключ сайта.`;
                break;
            case 2:
                error = `Ошибка #${num}. Не указан секретный ключ.`;
                break;
            case 3:
                error = `Ошибка #${num}. `;
                break;
            case 4:
                error = `Ошибка #${num}. Не указан минимальный балл.`;
                break;
            case 5:
                error = `Ошибка #${num}. Не удалось получить параметры.`;
                break;
            case 6:
                error = `Ошибка #${num}. Не удалось получить токен.`;
                break;
            case 7:
                error = `Ошибка #${num}. API Google: Не удалось получить ответ.`;
                break;
            case 8:
                error = `Ошибка #${num}. К сожалению, Google reCaptcha v3 решила, что вы бот :(.`;
                break;
            case 9:
                error = `Ошибка #${num}. API Google: не удалось проверить пользователя. ${this.errorCodes}.`;
                break;
        }
        console.log(error);
        return false;
    }
}
