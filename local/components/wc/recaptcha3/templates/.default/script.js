class ReCaptcha3 {
    constructor(props) {
        this.props = props;
    }

    getSiteKey() {
        BX.ajax.runComponentAction('wc:recaptcha3', 'getParams', {
            mode: 'class',
            signedParameters: this.props.signedParameters
        }).then(function (response) {
            if (response.status == 'success') {
                let siteKey = response.data.siteKey;
                let secretKey = response.data.secretKey;
                let action = response.data.action;
                if (typeof (siteKey) != 'undefined' && typeof (secretKey) != 'undefined' && typeof (action) != 'undefined') {
                    ReCaptcha3.siteVerify(siteKey, secretKey, action);
                }
            }
        });
    }

    static siteVerify(siteKey, secretKey, action) {
        grecaptcha.ready(function () {
            grecaptcha.execute(siteKey, {action: action}).then(function (token) {
                BX.ajax.runComponentAction('wc:recaptcha3', 'siteVerify', {
                    mode: 'class',
                    data: {
                        secretKey: secretKey,
                        token: token,
                    }
                }).then(function (response) {
                    if (response.data.response.success == true) {
                        let catpchaSid = document.getElementById('wcCaptchaSid').value;
                        ReCaptcha3.getCaptchaWord(catpchaSid).then(function (captchaWord) {
                            ReCaptcha3.setCaptchaWord(captchaWord);
                        });
                    }
                });
            });
        })
    }

    static setCaptchaWord(captchaWord) {
        document.getElementById('wcCaptchaWord').value = captchaWord;
    }

    static getCaptchaWord(catpchaSid) {
        return BX.ajax.runComponentAction('wc:recaptcha3', 'getCaptchaWord', {
            mode: 'class',
            data: {
                catpchaSid: catpchaSid,
            }
        }).then(function (response) {
            return response.data.captchaWord;
        });
    }
}