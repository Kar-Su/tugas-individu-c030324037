(function (window, document) {
    'use strict';

    const CrudHelper = {
        state: {
            alertTimer: null,
        },

        getToken: function () {
            try {
                return window.localStorage.getItem('api_token') || '';
            } catch (error) {
                return '';
            }
        },

        setToken: function (token) {
            try {
                if (token) {
                    window.localStorage.setItem('api_token', token);
                } else {
                    window.localStorage.removeItem('api_token');
                }
            } catch (error) {
                // ignore localStorage errors
            }
        },

        buildHeaders: function (extraHeaders) {
            const headers = Object.assign(
                {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                extraHeaders || {}
            );

            const token = this.getToken();
            if (token) {
                headers.Authorization = 'Bearer ' + token;
            }

            return headers;
        },

        normalizeResponseData: function (payload) {
            if (!payload) {
                return null;
            }

            if (typeof payload === 'object' && payload.data !== undefined) {
                return payload.data;
            }

            return payload;
        },

        extractErrorMessage: function (error, fallbackMessage) {
            if (!error) {
                return fallbackMessage || 'Terjadi kesalahan.';
            }

            if (typeof error === 'string') {
                return error;
            }

            if (error.message) {
                return error.message;
            }

            if (error.error) {
                return error.error;
            }

            return fallbackMessage || 'Terjadi kesalahan.';
        },

        request: async function (url, options) {
            const config = Object.assign(
                {
                    method: 'GET',
                    headers: {},
                },
                options || {}
            );

            const headers = this.buildHeaders(config.headers);

            if (config.body && typeof config.body !== 'string') {
                config.body = JSON.stringify(config.body);
            }

            config.headers = headers;

            const response = await fetch(url, config);

            let payload = null;
            const contentType = response.headers.get('content-type') || '';

            if (contentType.includes('application/json')) {
                payload = await response.json();
            } else {
                const text = await response.text();
                payload = text ? { message: text } : null;
            }

            if (!response.ok) {
                const message =
                    (payload && (payload.message || payload.error)) ||
                    'Permintaan ke server gagal.';
                throw new Error(message);
            }

            if (payload && payload.status && String(payload.status).toLowerCase() === 'error') {
                throw new Error(payload.message || 'Server mengembalikan status error.');
            }

            return payload;
        },

        get: function (url) {
            return this.request(url, {
                method: 'GET',
            });
        },

        post: function (url, body) {
            return this.request(url, {
                method: 'POST',
                body: body,
            });
        },

        put: function (url, body) {
            return this.request(url, {
                method: 'PUT',
                body: body,
            });
        },

        delete: function (url) {
            return this.request(url, {
                method: 'DELETE',
            });
        },

        escapeHtml: function (value) {
            const stringValue = value === null || value === undefined ? '' : String(value);

            return stringValue
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        },

        formatCurrency: function (value) {
            const number = Number(value || 0);

            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(number);
        },

        formatDateTime: function (value) {
            if (!value) {
                return '-';
            }

            const normalizedValue = String(value).replace(' ', 'T');
            const date = new Date(normalizedValue);

            if (Number.isNaN(date.getTime())) {
                return this.escapeHtml(value);
            }

            return new Intl.DateTimeFormat('id-ID', {
                dateStyle: 'medium',
                timeStyle: 'short',
            }).format(date);
        },

        clearAlert: function (containerId) {
            const container = document.getElementById(containerId || 'crud-alert');
            if (!container) {
                return;
            }

            container.innerHTML = '';

            if (this.state.alertTimer) {
                window.clearTimeout(this.state.alertTimer);
                this.state.alertTimer = null;
            }
        },

        showAlert: function (message, type, containerId, autoHide) {
            const container = document.getElementById(containerId || 'crud-alert');
            if (!container) {
                return;
            }

            const alertType = type || 'info';
            const shouldAutoHide = autoHide !== false;

            container.innerHTML =
                '<div class="alert alert-' +
                this.escapeHtml(alertType) +
                '" role="alert">' +
                this.escapeHtml(message) +
                '</div>';

            if (this.state.alertTimer) {
                window.clearTimeout(this.state.alertTimer);
            }

            if (shouldAutoHide) {
                this.state.alertTimer = window.setTimeout(function () {
                    container.innerHTML = '';
                }, 4000);
            }
        },

        renderTableEmpty: function (tbodyId, colspan, message) {
            const tbody = document.getElementById(tbodyId);
            if (!tbody) {
                return;
            }

            tbody.innerHTML =
                '<tr>' +
                '<td colspan="' +
                Number(colspan || 1) +
                '" class="text-center text-muted">' +
                this.escapeHtml(message || 'Data tidak tersedia.') +
                '</td>' +
                '</tr>';
        },

        confirmDelete: function (message) {
            return window.confirm(message || 'Yakin ingin menghapus data ini?');
        },

        setButtonLoading: function (button, isLoading, loadingText, defaultText) {
            if (!button) {
                return;
            }

            if (!button.dataset.defaultText) {
                button.dataset.defaultText = defaultText || button.innerHTML;
            }

            if (isLoading) {
                button.disabled = true;
                button.innerHTML = loadingText || 'Memproses...';
            } else {
                button.disabled = false;
                button.innerHTML = defaultText || button.dataset.defaultText;
            }
        },

        resetForm: function (form) {
            if (!form) {
                return;
            }

            form.reset();
        },

        toNumber: function (value, fallback) {
            const number = Number(value);
            return Number.isNaN(number) ? fallback || 0 : number;
        },

        fillSelectOptions: function (selectId, items, config) {
            const select = document.getElementById(selectId);
            if (!select) {
                return;
            }

            const settings = Object.assign(
                {
                    valueKey: 'id',
                    labelKey: 'name',
                    placeholder: 'Pilih data',
                    selectedValue: '',
                },
                config || {}
            );

            let html =
                '<option value="">' +
                this.escapeHtml(settings.placeholder) +
                '</option>';

            (items || []).forEach(
                function (item) {
                    const value = item[settings.valueKey];
                    const label =
                        typeof settings.label === 'function'
                            ? settings.label(item)
                            : item[settings.labelKey];

                    const selected =
                        String(value) === String(settings.selectedValue) ? ' selected' : '';

                    html +=
                        '<option value="' +
                        this.escapeHtml(value) +
                        '"' +
                        selected +
                        '>' +
                        this.escapeHtml(label) +
                        '</option>';
                }.bind(this)
            );

            select.innerHTML = html;
        },
    };

    window.CrudHelper = CrudHelper;
})(window, document);
