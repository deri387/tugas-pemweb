<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/datatables.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <div class="container mt-5">
        <button class="btn btn-sm btn-primary mb-3" onclick="openModal('add')">Buat baru</button>
        <table id="dataregister" class="table table-striped table-bordered w-100 mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data pendaftar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="form-group col-md-6">
                            <label for="nama_depan">Nama depan</label>
                            <input type="text" id="nama_depan" class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama_belakang">Nama belakang</label>
                            <input type="text" id="nama_belakang" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" />
                    </div>
                    <input type="hidden" id="type" value="create"/>
                    <input type="hidden" id="id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="createOrUpdate()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.datatables.js"></script>
    <script src="assets/js/datatables.bootstrap.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>