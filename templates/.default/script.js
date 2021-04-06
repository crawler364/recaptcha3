class ReCaptcha3 {
    async init(param) {
        this.badgeId = param.badgeId;
        this.params = await this.getParams(param.signedParameters);
        this.catpchaSid = document.getElementById(param.captchaSidId).value;
        this.$captchaWord = document.getElementById(param.captchaWordId);
        if (!this.params) {
            return false;
        }
        if (!this.isDefined(this.catpchaSid)) {
            return this.error(0);
        }
        this.handler();
    }

    handler() {
        grecaptcha.ready(async () => {
            let render = grecaptcha.render(this.badgeId, {
                'sitekey': this.params.siteKey,
                'badge': this.params.position,
                'size': 'invisible'
            });
            let token = await grecaptcha.execute(render, {action: this.params.action});
            if (!this.isDefined(token)) {
                return this.error(6);
            }
            let siteVerify = await this.siteVerify(this.params.secretKey, token);
            if (!this.isDefined(siteVerify)) {
                return this.error(7);
            }
            if (siteVerify.data.success == true) {
                if (siteVerify.data.score >= this.params.score) {
                    this.$captchaWord.value = await this.getCaptchaWord();
                } else {
                    return this.error(8);
                }
            } else {
                this.errorCodes = siteVerify.data["error-codes"].join('; ');
                return this.error(9);
            }
        });
    }

    async siteVerify(secretKey, token) {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'siteVerify', {
            mode: 'ajax',
            data: {
                secretKey: secretKey,
                token: token,
            }
        });
        if (response.status == 'success') {
            return response;
        }
        return false;
    }

    async getCaptchaWord() {
        let responce = await BX.ajax.runComponentAction('wc:recaptcha3', 'getCaptchaWord', {
            mode: 'ajax',
            data: {
                catpchaSid: this.catpchaSid,
            }
        });
        return responce.data.captchaWord;
    }

    async getParams(signedParameters) {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'getParams', {
            mode: 'ajax',
            signedParameters: signedParameters
        });
        if (response.status == 'success') {
            if (!this.isDefined(response.data.siteKey)) {
                return this.error(1);
            }
            if (!this.isDefined(response.data.secretKey)) {
                return this.error(2);
            }
            if (!this.isDefined(response.data.score)) {
                return this.error(4);
            }
            return response.data;
        }
        return this.error(5);
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
