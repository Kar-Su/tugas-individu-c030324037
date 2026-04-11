<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h5>User Management</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="#!">User</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="user-alert"></div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 id="user-form-title">Tambah User</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="user-form">
                                            <input type="hidden" id="user-id">

                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="username"
                                                    placeholder="Masukkan username"
                                                    required
                                                >
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="password"
                                                    placeholder="Masukkan password"
                                                >
                                                <small class="form-text text-muted">
                                                    Saat edit, kosongkan jika tidak ingin mengganti password.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select class="form-control" id="role" required>
                                                    <option value="Pelanggan">Pelanggan</option>
                                                    <option value="Admin">Admin</option>
                                                </select>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary" id="btn-submit-user">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="btn-reset-user">
                                                    Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                                        <h5>Data User</h5>
                                        <button type="button" class="btn btn-info btn-sm" id="btn-reload-user">
                                            Refresh
                                        </button>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                        <th>Created At</th>
                                                        <th style="min-width: 180px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="user-data">
                                                    <tr>
                                                        <td colspan="5" class="text-center">Memuat data...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Petunjuk</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="mb-0 pl-3">
                                            <li>Form di kiri digunakan untuk tambah dan edit user.</li>
                                            <li>Saat edit, password boleh dikosongkan jika tidak ingin diubah.</li>
                                            <li>Username hanya dikirim saat membuat user baru.</li>
                                            <li>Gunakan tombol <strong>Edit</strong> pada tabel untuk memuat data user ke form.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const apiBase = '/api/user';
    const form = document.getElementById('user-form');
    const tbody = document.getElementById('user-data');
    const alertBox = document.getElementById('user-alert');
    const formTitle = document.getElementById('user-form-title');
    const submitButton = document.getElementById('btn-submit-user');

    const inputId = document.getElementById('user-id');
    const inputUsername = document.getElementById('username');
    const inputPassword = document.getElementById('password');
    const inputRole = document.getElementById('role');

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showAlert(message, type) {
        const className = type === 'success' ? 'alert-success' : 'alert-danger';
        alertBox.innerHTML = `
            <div class="alert ${className} alert-dismissible fade show" role="alert">
                ${escapeHtml(message)}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function clearAlert() {
        alertBox.innerHTML = '';
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString.replace(' ', 'T'));
        if (Number.isNaN(date.getTime())) {
            return dateString;
        }
        return date.toLocaleString('id-ID');
    }

    function resetForm() {
        inputId.value = '';
        inputUsername.value = '';
        inputPassword.value = '';
        inputRole.value = 'Pelanggan';
        inputUsername.removeAttribute('readonly');
        formTitle.textContent = 'Tambah User';
        submitButton.textContent = 'Simpan';
    }

    async function parseResponse(response) {
        let data = {};
        try {
            data = await response.json();
        } catch (error) {
            data = {};
        }

        if (!response.ok || data.status === 'error') {
            throw new Error(data.message || 'Terjadi kesalahan saat memproses permintaan.');
        }

        return data;
    }

    async function loadUsers() {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">Memuat data...</td>
            </tr>
        `;

        try {
            const response = await fetch(apiBase);
            const result = await parseResponse(response);
            const users = Array.isArray(result.data) ? result.data : [];

            if (users.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data user.</td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = users.map(function (item) {
                const payload = encodeURIComponent(JSON.stringify(item));
                return `
                    <tr>
                        <td>${escapeHtml(item.id)}</td>
                        <td>${escapeHtml(item.username)}</td>
                        <td>
                            <span class="badge badge-info">${escapeHtml(item.role || '-')}</span>
                        </td>
                        <td>${escapeHtml(formatDate(item.created_at))}</td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-sm btn-warning"
                                onclick="window.editUser('${payload}')"
                            >
                                Edit
                            </button>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                onclick="window.deleteUser('${escapeHtml(item.id)}', '${escapeHtml(item.username)}')"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        } catch (error) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">${escapeHtml(error.message)}</td>
                </tr>
            `;
            showAlert(error.message, 'error');
        }
    }

    window.editUser = function (encodedItem) {
        clearAlert();

        try {
            const item = JSON.parse(decodeURIComponent(encodedItem));
            inputId.value = item.id || '';
            inputUsername.value = item.username || '';
            inputPassword.value = '';
            inputRole.value = item.role || 'Pelanggan';

            inputUsername.setAttribute('readonly', 'readonly');
            formTitle.textContent = 'Edit User';
            submitButton.textContent = 'Update';

            window.scrollTo({ top: 0, behavior: 'smooth' });
        } catch (error) {
            showAlert('Gagal memuat data user untuk diedit.', 'error');
        }
    };

    window.deleteUser = async function (id, username) {
        clearAlert();

        if (!confirm('Yakin ingin menghapus user "' + username + '"?')) {
            return;
        }

        try {
            const response = await fetch(apiBase + '/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const result = await parseResponse(response);
            showAlert(result.message || 'User berhasil dihapus.', 'success');

            if (String(inputId.value) === String(id)) {
                resetForm();
            }

            loadUsers();
        } catch (error) {
            showAlert(error.message, 'error');
        }
    };

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearAlert();

        const id = inputId.value.trim();
        const isEdit = id !== '';

        const payload = {};

        if (!isEdit) {
            payload.username = inputUsername.value.trim();
            payload.password = inputPassword.value;

            if (!payload.username) {
                showAlert('Username wajib diisi.', 'error');
                return;
            }

            if (!payload.password) {
                showAlert('Password wajib diisi saat membuat user.', 'error');
                return;
            }

            payload.role = inputRole.value;
        } else {
            if (inputPassword.value.trim() !== '') {
                payload.password = inputPassword.value;
            }
            payload.role = inputRole.value;
        }

        try {
            const response = await fetch(isEdit ? apiBase + '/' + id : apiBase, {
                method: isEdit ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await parseResponse(response);
            showAlert(
                result.message || (isEdit ? 'User berhasil diperbarui.' : 'User berhasil ditambahkan.'),
                'success'
            );

            resetForm();
            loadUsers();
        } catch (error) {
            showAlert(error.message, 'error');
        }
    });

    document.getElementById('btn-reset-user').addEventListener('click', function () {
        clearAlert();
        resetForm();
    });

    document.getElementById('btn-reload-user').addEventListener('click', function () {
        clearAlert();
        loadUsers();
    });

    resetForm();
    loadUsers();
})();
</script>
