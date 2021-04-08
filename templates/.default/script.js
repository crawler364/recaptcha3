class ReCaptcha3 {
    constructor(params) {
        this.siteKey = params.siteKey;
        this.position = params.position;
        this.action = params.action;
        this.signedParameters = params.signedParameters;
    }

    init(params) {
        this.captchaSidContainer = BX.findChild(BX(params.captchaId), {attribute: {'data-type': 'captcha-sid'}}, true, false);
        this.captchaWordContainer = BX.findChild(BX(params.captchaId), {attribute: {'data-type': 'captcha-word'}}, true, false);
        this.badgeContainer = BX.findChild(BX(params.captchaId), {attribute: {'data-type': 'badge'}}, true, false);

        this.handler();
    }

    handler() {
        grecaptcha.ready(async () => {
            console.log(this.siteKey)
            let render = grecaptcha.render(this.badgeContainer, {
                'sitekey': this.siteKey,
                'badge': this.position,
                'size': 'invisible'
            });
            console.log(render);
            let token = await grecaptcha.execute(render, {action: this.action});
            console.log(token);

            if (!this.isDefined(token)) {
                return this.error(6);
            }

            let siteVerify = await this.siteVerify(token);
            console.log(siteVerify);
            if (!this.isDefined(siteVerify)) {
                return this.error(7);
            }

           /* if (siteVerify.data.success == true) {
                if (siteVerify.data.score >= this.params.score) {
                    this.$captchaWord.value = await this.getCaptchaWord();
                } else {
                    return this.error(8);
                }
            } else {
                this.errorCodes = siteVerify.data["error-codes"].join('; ');
                return this.error(9);
            }*/
        });
    }

    async siteVerify(token) {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'siteVerify', {
            mode: 'ajax',
            data: {
                token: token,
            },
            signedParameters: this.signedParameters,
        });
        if (response.status === 'success') {
            return response;
        }
        return false;
    }

    async getCaptchaWord() {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'getCaptchaWord', {
            mode: 'ajax',
            data: {
                captchaSid: this.catpchaSid,
            }
        });
        return response.data.captchaWord;
    }

    isDefined(param) {
        if (typeof param == 'undefined' || param == '') {
            return false;
        }
        return true;
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
