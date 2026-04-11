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
                                        <div class="page-header-title"><h5>Tambah Pesanan</h5></div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="?page=order/index">List Order</a></li>
                                            <li class="breadcrumb-item"><a href="#!">Tambah</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header"><h5>Form Pesanan Baru</h5></div>
                                    <div class="card-body">
                                        <form id="form-tambah-order">
                                            <div class="form-group">
                                                <label>Pilih Pelanggan</label>
                                                <select class="form-control" id="select-user" required>
                                                    <option value="">Memuat user...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Menu</label>
                                                <select class="form-control" id="select-menu" required>
                                                    <option value="">Memuat menu...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Total Harga</label>
                                                <input type="number" class="form-control" id="input-total" placeholder="Harga akan muncul otomatis" readonly>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                                            <a href="?page=order/index" class="btn btn-light">Batal</a>
                                        </form>
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
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/user')
        .then(res => res.json())
        .then(res => {
            const selectUser = document.getElementById('select-user');
            selectUser.innerHTML = '<option value=""> Pilih User </option>';
            res.data.forEach(user => {
                selectUser.innerHTML += `<option value="${user.id}">${user.username} (ID: ${user.id})</option>`;
            });
        });

    fetch('/api/menu')
        .then(res => res.json())
        .then(res => {
            const selectMenu = document.getElementById('select-menu');
            selectMenu.innerHTML = '<option value=""> Pilih Menu </option>';
            res.data.forEach(menu => {
                selectMenu.innerHTML += `<option value="${menu.id}" data-price="${menu.price}">${menu.name} - Rp ${menu.price}</option>`;
            });
        });

    document.getElementById('select-menu').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('input-total').value = price || 0;
    });

</script>
