class ReCaptcha3 {
    constructor(param) {
        this.param = param;
        this.catpchaSid = document.getElementById('wcCaptchaSid').value;
    }

    async getParams() {
        let response = await BX.ajax.runComponentAction('wc:recaptcha3', 'getParams', {
            mode: 'class',
            signedParameters: this.param.signedParameters
        });
        if (response.status == 'success') {
            if (!this.isDefined(response.data.siteKey)) {
                return this.error(1);
            }
            if (!this.isDefined(response.data.secretKey)) {
                return this.error(2);
            }
            if (!this.isDefined(response.data.action)) {
                return this.error(3);
            }
            if (!this.isDefined(response.data.score)) {
                return this.error(4);
            }
            return response;
        }
        return this.error(5);
    }

    handler() {
        if (!this.isDefined(this.catpchaSid)) {
            return this.error(0);
        }
        grecaptcha.ready(async () => {
            let params = await this.getParams();
            if (!this.isDefined(params)) {
                return;
            }
            let token = await grecaptcha.execute(params.data.siteKey, {action: params.data.action});
            if (!this.isDefined(token)) {
                return this.error(6);
            }
            let siteVerify = await this.siteVerify(params.data.secretKey, token);
            if (!this.isDefined(siteVerify)) {
                return this.error(7);
            }
            if (siteVerify.data.success == true) {
                if (siteVerify.data.score >= params.data.score) {
                    document.getElementById('wcCaptchaWord').value = await this.getCaptchaWord();
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
            mode: 'class',
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
            mode: 'class',
            data: {
                catpchaSid: this.catpchaSid,
            }
        });
        return responce.data.captchaWord;
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
                error = `Ошибка #${num}. Не указан тип действия.`;
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

    isDefined(param) {
        if (typeof param == 'undefined' || param == '') {
            return false;
        }
        return true;
    }
}