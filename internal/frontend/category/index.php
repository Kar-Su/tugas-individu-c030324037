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
                                            <h5>Category</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="#!">CRUD Category</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 id="category-form-title">Tambah Kategori</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="category-alert"></div>

                                        <form id="category-form">
                                            <input type="hidden" id="category-id">

                                            <div class="form-group">
                                                <label for="category-name">Nama Kategori</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="category-name"
                                                    placeholder="Masukkan nama kategori"
                                                    required
                                                >
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary mr-2" id="category-submit-btn">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="category-cancel-btn" style="display: none;">
                                                    Batal Edit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-12">
                                <div class="card">
                                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
                                        <h5>Data Kategori</h5>
                                        <button class="btn btn-outline-primary" id="refresh-category-btn">
                                            Refresh
                                        </button>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div id="category-table-alert"></div>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 90px;">ID</th>
                                                        <th>Nama Kategori</th>
                                                        <th style="width: 220px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="category-data">
                                                    <tr>
                                                        <td colspan="3" class="text-center">Memuat data...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</div>

<script>
(function () {
    const endpoint = '/api/category';

    const form = document.getElementById('category-form');
    const idInput = document.getElementById('category-id');
    const nameInput = document.getElementById('category-name');
    const submitButton = document.getElementById('category-submit-btn');
    const cancelButton = document.getElementById('category-cancel-btn');
    const formTitle = document.getElementById('category-form-title');
    const tbody = document.getElementById('category-data');
    const formAlert = document.getElementById('category-alert');
    const tableAlert = document.getElementById('category-table-alert');
    const refreshButton = document.getElementById('refresh-category-btn');

    let categories = [];

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showAlert(target, type, message) {
        target.innerHTML = `
            <div class="alert alert-${type}" role="alert">
                ${escapeHtml(message)}
            </div>
        `;
    }

    function clearAlert(target) {
        target.innerHTML = '';
    }

    function resetForm() {
        form.reset();
        idInput.value = '';
        formTitle.textContent = 'Tambah Kategori';
        submitButton.textContent = 'Simpan';
        cancelButton.style.display = 'none';
    }

    function renderTable(data) {
        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center">Belum ada data kategori.</td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = data.map(function (item) {
            return `
                <tr>
                    <td>${escapeHtml(item.id)}</td>
                    <td>${escapeHtml(item.category_name)}</td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-sm btn-warning mr-2"
                            onclick="window.categoryCrudEdit(${Number(item.id)})"
                        >
                            Edit
                        </button>
                        <button
                            type="button"
                            class="btn btn-sm btn-danger"
                            onclick="window.categoryCrudDelete(${Number(item.id)})"
                        >
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    async function request(url, options) {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json'
            },
            ...options
        });

        let result = {};
        try {
            result = await response.json();
        } catch (error) {
            result = {};
        }

        if (!response.ok) {
            throw new Error(result.message || 'Terjadi kesalahan saat memproses permintaan.');
        }

        if (result.status && String(result.status).toLowerCase() === 'error') {
            throw new Error(result.message || 'Permintaan gagal.');
        }

        return result;
    }

    async function loadCategories() {
        clearAlert(tableAlert);
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center">Memuat data...</td>
            </tr>
        `;

        try {
            const result = await request(endpoint, { method: 'GET' });
            categories = Array.isArray(result.data) ? result.data : [];
            renderTable(categories);
        } catch (error) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-danger">Gagal memuat data.</td>
                </tr>
            `;
            showAlert(tableAlert, 'danger', error.message || 'Gagal memuat data kategori.');
        }
    }

    function setEditMode(id) {
        const category = categories.find(function (item) {
            return String(item.id) === String(id);
        });

        if (!category) {
            showAlert(tableAlert, 'warning', 'Data kategori tidak ditemukan.');
            return;
        }

        clearAlert(formAlert);
        idInput.value = category.id;
        nameInput.value = category.category_name || '';
        formTitle.textContent = 'Edit Kategori';
        submitButton.textContent = 'Update';
        cancelButton.style.display = 'inline-block';
        nameInput.focus();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    async function deleteCategory(id) {
        const confirmed = window.confirm('Yakin ingin menghapus kategori ini?');
        if (!confirmed) {
            return;
        }

        clearAlert(tableAlert);

        try {
            const result = await request(endpoint + '/' + id, {
                method: 'DELETE'
            });
            showAlert(tableAlert, 'success', result.message || 'Kategori berhasil dihapus.');
            if (String(idInput.value) === String(id)) {
                resetForm();
            }
            await loadCategories();
        } catch (error) {
            showAlert(tableAlert, 'danger', error.message || 'Gagal menghapus kategori.');
        }
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearAlert(formAlert);

        const categoryName = nameInput.value.trim();
        if (!categoryName) {
            showAlert(formAlert, 'warning', 'Nama kategori wajib diisi.');
            return;
        }

        const id = idInput.value.trim();
        const isEdit = Boolean(id);

        const payload = {
            category_name: categoryName
        };

        try {
            const result = await request(isEdit ? endpoint + '/' + id : endpoint, {
                method: isEdit ? 'PUT' : 'POST',
                body: JSON.stringify(payload)
            });

            showAlert(
                formAlert,
                'success',
                result.message || (isEdit ? 'Kategori berhasil diupdate.' : 'Kategori berhasil ditambahkan.')
            );
            resetForm();
            await loadCategories();
        } catch (error) {
            showAlert(formAlert, 'danger', error.message || 'Gagal menyimpan kategori.');
        }
    });

    cancelButton.addEventListener('click', function () {
        clearAlert(formAlert);
        resetForm();
    });

    refreshButton.addEventListener('click', function () {
        loadCategories();
    });

    window.categoryCrudEdit = setEditMode;
    window.categoryCrudDelete = deleteCategory;

    document.addEventListener('DOMContentLoaded', function () {
        resetForm();
        loadCategories();
    });

    resetForm();
    loadCategories();
})();
</script>
