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
                                            <h5>Order</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="#!">CRUD Order</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="order-alert"></div>

                        <div class="row">
                            <div class="col-lg-5 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Buat Pesanan</h5>
                                        <span>Pilih user dan isi total harga untuk membuat order baru.</span>
                                    </div>
                                    <div class="card-body">
                                        <form id="create-order-form">
                                            <div class="form-group">
                                                <label for="order-user-id">User</label>
                                                <select class="form-control" id="order-user-id" required>
                                                    <option value="">Memuat data user...</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="order-menu-helper">Menu (opsional, untuk bantu isi harga)</label>
                                                <select class="form-control" id="order-menu-helper">
                                                    <option value="">Pilih menu</option>
                                                </select>
                                                <small class="form-text text-muted">
                                                    API order hanya membutuhkan <code>user_id</code> dan <code>total_price</code>. Pilihan menu ini hanya membantu mengisi harga otomatis.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="order-total-price">Total Harga</label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="order-total-price"
                                                    min="0"
                                                    step="1"
                                                    placeholder="Masukkan total harga"
                                                    required
                                                >
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather icon-save"></i> Simpan Pesanan
                                            </button>
                                            <button type="button" class="btn btn-light" id="reset-create-order">
                                                Reset
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Ubah Status Pesanan</h5>
                                        <span>Pilih salah satu order dari tabel untuk mengubah statusnya.</span>
                                    </div>
                                    <div class="card-body">
                                        <form id="update-order-form">
                                            <input type="hidden" id="update-order-id">

                                            <div class="form-group">
                                                <label for="update-order-number">Order Terpilih</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="update-order-number"
                                                    placeholder="Belum ada order dipilih"
                                                    readonly
                                                >
                                            </div>

                                            <div class="form-group">
                                                <label for="update-order-status">Status</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="update-order-status"
                                                    list="order-status-list"
                                                    placeholder="Contoh: Diproses"
                                                    required
                                                >
                                                <datalist id="order-status-list">
                                                    <option value="Diproses"></option>
                                                    <option value="Selesai"></option>
                                                    <option value="Dibatalkan"></option>
                                                    <option value="Menunggu Pembayaran"></option>
                                                </datalist>
                                            </div>

                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-edit"></i> Update Status
                                            </button>
                                            <button type="button" class="btn btn-light" id="cancel-update-order">
                                                Batal
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7 col-md-12">
                                <div class="card">
                                    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                                        <div>
                                            <h5>Data Order</h5>
                                            <span>Daftar pesanan yang tersimpan di sistem.</span>
                                        </div>
                                        <button type="button" class="btn btn-success" id="reload-order-data">
                                            <i class="feather icon-refresh-cw"></i> Refresh
                                        </button>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>User</th>
                                                        <th>Status</th>
                                                        <th>Total Harga</th>
                                                        <th>Tanggal</th>
                                                        <th style="min-width: 160px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="order-data">
                                                    <tr>
                                                        <td colspan="6" class="text-center">Memuat data...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Detail Singkat</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-4 col-12 mb-3">
                                                <div class="border rounded p-3">
                                                    <h6 class="mb-1">Total Order</h6>
                                                    <h4 class="mb-0" id="order-total-count">0</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <div class="border rounded p-3">
                                                    <h6 class="mb-1">Sedang Dipilih</h6>
                                                    <h4 class="mb-0" id="order-selected-id">-</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 mb-3">
                                                <div class="border rounded p-3">
                                                    <h6 class="mb-1">Total Nilai Order</h6>
                                                    <h4 class="mb-0" id="order-total-amount">Rp 0</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- page-wrapper -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const endpoints = {
        orders: '/api/order',
        users: '/api/user',
        menus: '/api/menu'
    };

    const state = {
        orders: [],
        users: [],
        menus: [],
        selectedOrderId: null
    };

    const alertContainer = document.getElementById('order-alert');
    const orderTableBody = document.getElementById('order-data');

    const createForm = document.getElementById('create-order-form');
    const updateForm = document.getElementById('update-order-form');

    const userSelect = document.getElementById('order-user-id');
    const menuHelperSelect = document.getElementById('order-menu-helper');
    const totalPriceInput = document.getElementById('order-total-price');

    const selectedIdLabel = document.getElementById('order-selected-id');
    const selectedOrderInput = document.getElementById('update-order-number');
    const updateOrderIdInput = document.getElementById('update-order-id');
    const updateOrderStatusInput = document.getElementById('update-order-status');

    const totalCountLabel = document.getElementById('order-total-count');
    const totalAmountLabel = document.getElementById('order-total-amount');

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatCurrency(value) {
        const number = Number(value || 0);
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function formatDate(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(value.replace(' ', 'T'));
        if (Number.isNaN(date.getTime())) {
            return escapeHtml(value);
        }

        return date.toLocaleString('id-ID');
    }

    function showAlert(message, type) {
        alertContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${escapeHtml(message)}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    async function apiRequest(url, options = {}) {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                ...(options.headers || {})
            },
            ...options
        });

        let payload = {};
        try {
            payload = await response.json();
        } catch (error) {
            payload = {};
        }

        if (!response.ok || payload.status === 'error') {
            throw new Error(payload.message || 'Terjadi kesalahan saat menghubungi API.');
        }

        return payload;
    }

    function getUserName(userId) {
        const user = state.users.find(function (item) {
            return String(item.id) === String(userId);
        });

        return user ? user.username : 'User #' + userId;
    }

    function populateUserSelect() {
        if (!state.users.length) {
            userSelect.innerHTML = '<option value="">Data user tidak tersedia</option>';
            return;
        }

        userSelect.innerHTML = '<option value="">Pilih user</option>' + state.users.map(function (user) {
            return `<option value="${escapeHtml(user.id)}">${escapeHtml(user.username)} - ${escapeHtml(user.role || '-')}</option>`;
        }).join('');
    }

    function populateMenuHelperSelect() {
        if (!state.menus.length) {
            menuHelperSelect.innerHTML = '<option value="">Data menu tidak tersedia</option>';
            return;
        }

        menuHelperSelect.innerHTML = '<option value="">Pilih menu</option>' + state.menus.map(function (menu) {
            return `<option value="${escapeHtml(menu.id)}" data-price="${escapeHtml(menu.price)}">${escapeHtml(menu.menu_name)} - ${formatCurrency(menu.price)}</option>`;
        }).join('');
    }

    function resetCreateForm() {
        createForm.reset();
        menuHelperSelect.value = '';
    }

    function resetUpdateForm() {
        state.selectedOrderId = null;
        updateOrderIdInput.value = '';
        selectedOrderInput.value = '';
        updateOrderStatusInput.value = '';
        selectedIdLabel.textContent = '-';
    }

    function selectOrder(orderId) {
        const order = state.orders.find(function (item) {
            return String(item.id) === String(orderId);
        });

        if (!order) {
            showAlert('Data order tidak ditemukan.', 'warning');
            return;
        }

        state.selectedOrderId = order.id;
        updateOrderIdInput.value = order.id;
        selectedOrderInput.value = '#ORD-' + order.id + ' | ' + getUserName(order.user_id);
        updateOrderStatusInput.value = order.status || '';
        selectedIdLabel.textContent = order.id;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function renderSummary() {
        totalCountLabel.textContent = state.orders.length;

        const totalAmount = state.orders.reduce(function (sum, order) {
            return sum + Number(order.total_price || 0);
        }, 0);

        totalAmountLabel.textContent = formatCurrency(totalAmount);
    }

    function renderOrders() {
        if (!state.orders.length) {
            orderTableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center">Belum ada data order.</td>
                </tr>
            `;
            renderSummary();
            return;
        }

        orderTableBody.innerHTML = state.orders.map(function (order) {
            const isSelected = String(order.id) === String(state.selectedOrderId);
            return `
                <tr ${isSelected ? 'style="background-color: rgba(114, 124, 245, 0.08);"' : ''}>
                    <td>#ORD-${escapeHtml(order.id)}</td>
                    <td>${escapeHtml(getUserName(order.user_id))}</td>
                    <td>
                        <span class="badge badge-${(order.status || '').toLowerCase() === 'selesai' ? 'success' : ((order.status || '').toLowerCase() === 'dibatalkan' ? 'danger' : 'warning')}">
                            ${escapeHtml(order.status || 'Belum diatur')}
                        </span>
                    </td>
                    <td>${formatCurrency(order.total_price)}</td>
                    <td>${formatDate(order.created_at)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning" onclick="window.orderCrudSelect('${escapeHtml(order.id)}')">
                            Edit Status
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="window.orderCrudDelete('${escapeHtml(order.id)}')">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        }).join('');

        renderSummary();
    }

    async function loadReferenceData() {
        const [usersResponse, menusResponse] = await Promise.all([
            apiRequest(endpoints.users),
            apiRequest(endpoints.menus)
        ]);

        state.users = Array.isArray(usersResponse.data) ? usersResponse.data : [];
        state.menus = Array.isArray(menusResponse.data) ? menusResponse.data : [];

        populateUserSelect();
        populateMenuHelperSelect();
    }

    async function loadOrders() {
        orderTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center">Memuat data...</td>
            </tr>
        `;

        const response = await apiRequest(endpoints.orders);
        state.orders = Array.isArray(response.data) ? response.data : [];
        renderOrders();
    }

    async function createOrder(event) {
        event.preventDefault();

        const userId = userSelect.value;
        const totalPrice = totalPriceInput.value;

        if (!userId || totalPrice === '') {
            showAlert('User dan total harga wajib diisi.', 'warning');
            return;
        }

        try {
            const response = await apiRequest(endpoints.orders, {
                method: 'POST',
                body: JSON.stringify({
                    user_id: Number(userId),
                    total_price: Number(totalPrice)
                })
            });

            showAlert(response.message || 'Pesanan berhasil dibuat.', 'success');
            resetCreateForm();
            await loadOrders();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    async function updateOrderStatus(event) {
        event.preventDefault();

        const orderId = updateOrderIdInput.value;
        const status = updateOrderStatusInput.value.trim();

        if (!orderId) {
            showAlert('Pilih order yang ingin diupdate terlebih dahulu.', 'warning');
            return;
        }

        if (!status) {
            showAlert('Status order wajib diisi.', 'warning');
            return;
        }

        try {
            const response = await apiRequest(endpoints.orders + '/' + orderId, {
                method: 'PUT',
                body: JSON.stringify({
                    status: status
                })
            });

            showAlert(response.message || 'Status order berhasil diperbarui.', 'success');
            await loadOrders();
            selectOrder(orderId);
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    async function deleteOrder(orderId) {
        if (!confirm('Yakin ingin menghapus order ini?')) {
            return;
        }

        try {
            const response = await apiRequest(endpoints.orders + '/' + orderId, {
                method: 'DELETE'
            });

            showAlert(response.message || 'Order berhasil dihapus.', 'success');

            if (String(state.selectedOrderId) === String(orderId)) {
                resetUpdateForm();
            }

            await loadOrders();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    function bindEvents() {
        createForm.addEventListener('submit', createOrder);
        updateForm.addEventListener('submit', updateOrderStatus);

        document.getElementById('reset-create-order').addEventListener('click', resetCreateForm);
        document.getElementById('cancel-update-order').addEventListener('click', resetUpdateForm);
        document.getElementById('reload-order-data').addEventListener('click', function () {
            initialize();
        });

        menuHelperSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption ? selectedOption.getAttribute('data-price') : '';

            if (price) {
                totalPriceInput.value = price;
            }
        });
    }

    async function initialize() {
        try {
            await loadReferenceData();
            await loadOrders();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    window.orderCrudSelect = selectOrder;
    window.orderCrudDelete = deleteOrder;

    bindEvents();
    resetUpdateForm();
    initialize();
})();
</script>
