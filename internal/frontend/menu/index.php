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
                                            <h5>Menu</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="#!">CRUD Menu</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 id="menu-form-title">Tambah Menu</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="menu-alert"></div>

                                        <form id="menu-form">
                                            <input type="hidden" id="menu-id">

                                            <div class="form-group">
                                                <label for="menu-name">Nama Menu</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="menu-name"
                                                    placeholder="Contoh: Nasi Goreng"
                                                    required
                                                >
                                            </div>

                                            <div class="form-group">
                                                <label for="menu-price">Harga</label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="menu-price"
                                                    placeholder="Contoh: 15000"
                                                    min="0"
                                                    required
                                                >
                                            </div>

                                            <div class="form-group">
                                                <label for="menu-category">Kategori</label>
                                                <select class="form-control" id="menu-category" required>
                                                    <option value="">Memuat kategori...</option>
                                                </select>
                                            </div>

                                            <div class="d-flex" style="gap: 8px; flex-wrap: wrap;">
                                                <button type="submit" class="btn btn-primary" id="menu-submit-btn">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary" id="menu-cancel-btn" style="display: none;">
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
                                        <h5>Data Menu</h5>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="menu-refresh-btn">
                                            Refresh
                                        </button>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div id="menu-table-alert"></div>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nama Menu</th>
                                                        <th>Harga</th>
                                                        <th>Kategori</th>
                                                        <th style="min-width: 160px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="menu-data">
                                                    <tr>
                                                        <td colspan="5" class="text-center">Memuat data menu...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Informasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">
                                            Halaman ini mendukung CRUD penuh untuk data menu:
                                            tambah, lihat daftar, edit, dan hapus.
                                        </p>
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
    const state = {
        menus: [],
        categories: [],
        editingId: null
    };

    const menuForm = document.getElementById('menu-form');
    const menuIdInput = document.getElementById('menu-id');
    const menuNameInput = document.getElementById('menu-name');
    const menuPriceInput = document.getElementById('menu-price');
    const menuCategoryInput = document.getElementById('menu-category');
    const menuSubmitBtn = document.getElementById('menu-submit-btn');
    const menuCancelBtn = document.getElementById('menu-cancel-btn');
    const menuFormTitle = document.getElementById('menu-form-title');
    const menuAlert = document.getElementById('menu-alert');
    const menuTableAlert = document.getElementById('menu-table-alert');
    const menuTableBody = document.getElementById('menu-data');
    const menuRefreshBtn = document.getElementById('menu-refresh-btn');

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatCurrency(value) {
        const amount = Number(value || 0);
        return 'Rp ' + amount.toLocaleString('id-ID');
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

    async function parseResponse(response) {
        const text = await response.text();
        let data = {};

        try {
            data = text ? JSON.parse(text) : {};
        } catch (error) {
            data = {};
        }

        if (!response.ok) {
            throw new Error(data.message || 'Request gagal diproses');
        }

        return data;
    }

    async function apiRequest(url, options) {
        const response = await fetch(url, options || {});
        return parseResponse(response);
    }

    function resetForm() {
        state.editingId = null;
        menuIdInput.value = '';
        menuNameInput.value = '';
        menuPriceInput.value = '';
        menuCategoryInput.value = '';
        menuFormTitle.textContent = 'Tambah Menu';
        menuSubmitBtn.textContent = 'Simpan';
        menuCancelBtn.style.display = 'none';
        clearAlert(menuAlert);
    }

    function populateCategoryOptions() {
        if (!state.categories.length) {
            menuCategoryInput.innerHTML = '<option value="">Data kategori tidak tersedia</option>';
            return;
        }

        menuCategoryInput.innerHTML = '<option value="">Pilih kategori</option>' + state.categories.map(function (category) {
            return `<option value="${category.id}">${escapeHtml(category.category_name)}</option>`;
        }).join('');
    }

    function renderTable() {
        if (!state.menus.length) {
            menuTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">Belum ada data menu.</td>
                </tr>
            `;
            return;
        }

        menuTableBody.innerHTML = state.menus.map(function (item) {
            const categoryName = item.category && item.category.category_name
                ? item.category.category_name
                : '-';

            return `
                <tr>
                    <td>${escapeHtml(item.id)}</td>
                    <td>${escapeHtml(item.menu_name)}</td>
                    <td>${escapeHtml(formatCurrency(item.price))}</td>
                    <td>${escapeHtml(categoryName)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.menuCrudEdit(${Number(item.id)})">
                            Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="window.menuCrudDelete(${Number(item.id)})">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    async function loadCategories() {
        const res = await apiRequest('/api/category', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        state.categories = Array.isArray(res.data) ? res.data : [];
        populateCategoryOptions();
    }

    async function loadMenus() {
        clearAlert(menuTableAlert);
        menuTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">Memuat data menu...</td>
            </tr>
        `;

        const res = await apiRequest('/api/menu', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        state.menus = Array.isArray(res.data) ? res.data : [];
        renderTable();
    }

    function fillFormForEdit(item) {
        state.editingId = item.id;
        menuIdInput.value = item.id;
        menuNameInput.value = item.menu_name || '';
        menuPriceInput.value = item.price || '';
        menuCategoryInput.value = item.category_id || '';
        menuFormTitle.textContent = 'Edit Menu';
        menuSubmitBtn.textContent = 'Update';
        menuCancelBtn.style.display = 'inline-block';
        clearAlert(menuAlert);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    async function submitForm(event) {
        event.preventDefault();
        clearAlert(menuAlert);

        const payload = {
            menu_name: menuNameInput.value.trim(),
            price: Number(menuPriceInput.value),
            category_id: Number(menuCategoryInput.value)
        };

        if (!payload.menu_name) {
            showAlert(menuAlert, 'danger', 'Nama menu wajib diisi.');
            return;
        }

        if (Number.isNaN(payload.price) || payload.price < 0) {
            showAlert(menuAlert, 'danger', 'Harga menu harus berupa angka valid.');
            return;
        }

        if (!payload.category_id) {
            showAlert(menuAlert, 'danger', 'Kategori wajib dipilih.');
            return;
        }

        try {
            if (state.editingId) {
                await apiRequest('/api/menu/' + state.editingId, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                showAlert(menuAlert, 'success', 'Menu berhasil diperbarui.');
            } else {
                await apiRequest('/api/menu', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                showAlert(menuAlert, 'success', 'Menu berhasil ditambahkan.');
            }

            resetForm();
            await loadMenus();
        } catch (error) {
            showAlert(menuAlert, 'danger', error.message || 'Gagal menyimpan data menu.');
        }
    }

    async function editMenu(id) {
        const existingItem = state.menus.find(function (item) {
            return Number(item.id) === Number(id);
        });

        if (existingItem) {
            fillFormForEdit(existingItem);
            return;
        }

        try {
            const res = await apiRequest('/api/menu/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const data = Array.isArray(res.data) ? res.data[0] : res.data;

            if (!data) {
                throw new Error('Data menu tidak ditemukan.');
            }

            fillFormForEdit(data);
        } catch (error) {
            showAlert(menuTableAlert, 'danger', error.message || 'Gagal memuat detail menu.');
        }
    }

    async function deleteMenu(id) {
        const confirmed = window.confirm('Yakin ingin menghapus menu ini?');
        if (!confirmed) {
            return;
        }

        try {
            await apiRequest('/api/menu/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            showAlert(menuTableAlert, 'success', 'Menu berhasil dihapus.');

            if (Number(state.editingId) === Number(id)) {
                resetForm();
            }

            await loadMenus();
        } catch (error) {
            showAlert(menuTableAlert, 'danger', error.message || 'Gagal menghapus menu.');
        }
    }

    async function initializePage() {
        try {
            await loadCategories();
            await loadMenus();
        } catch (error) {
            showAlert(menuTableAlert, 'danger', error.message || 'Gagal memuat data halaman menu.');
            populateCategoryOptions();
        }
    }

    menuForm.addEventListener('submit', submitForm);
    menuCancelBtn.addEventListener('click', resetForm);
    menuRefreshBtn.addEventListener('click', initializePage);

    window.menuCrudEdit = editMenu;
    window.menuCrudDelete = deleteMenu;

    document.addEventListener('DOMContentLoaded', initializePage);
})();
</script>
