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
        this.badgeContainer = BX.findChild(BX(params.captchaId), {attribute: {'data-type': 'badge'}}, true, false);

        this.handler().then();
    }

    async handler() {
        let render = await grecaptcha.render(this.badgeContainer, {
            'sitekey': this.siteKey,
            'badge': this.position,
            'size': 'invisible'
        });
        let token = await grecaptcha.execute(render, {
            action: this.action
        });

        BX.ajax.runComponentAction('wc:recaptcha3', 'siteVerify', {
            mode: 'ajax',
            data: {token: token},
            signedParameters: this.signedParameters,
        }).then((response) => {
            BX.ajax.runComponentAction('wc:recaptcha3', 'processCaptcha', {
                mode: 'ajax',
                data: {
                    captchaSid: this.captchaSid,
                }
            }).then((response) => {
                this.captchaWordContainer.value = response.data.captchaWord;
            }, (response) => {
                response.errors.forEach(function (error) {
                    console.error(error.message);
                });
            });
        }, (response) => {
            response.errors.forEach(function (error) {
                console.error(error.message);
            });
        });
    }
}
