<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ breadcrumb ] start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h5>Menu</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"
                                                    ><i
                                                        class="feather icon-home"
                                                    ></i
                                                ></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="#!">List Menu</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <form>
                                <input type="text" id="menu_nama" placeholder="Nama Menu">
                                <input type="text" id="price" placeholder="Harga Menu">
                                <button type="button" onclick="updateMenu()">Update</button>
                            </form>
                        </div>

                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<script>
  async function updateMenu() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    const nama = document.getElementById("menu_nama").value;
    const price = document.getElementById("price").value;

    const res = await fetch("http://localhost/api/menu/" + id, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        menu_name: nama,
        price: parseInt(price),
      }),
    });

    if (res.ok) {
      alert("Menu updated successfully");
      window.location.href = "index.php";
    }
  }
</script>
