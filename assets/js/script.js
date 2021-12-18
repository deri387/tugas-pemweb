$(document).ready(function () {
  get();
});

function openModal(type) {
  if (type === "add") {
    $("#modal").modal("show");
  }
}

function get() {
  $("#dataregister").DataTable({
    processing: true,
    serverSide: true,
    columnDefs: [
      {
        targets: [0, 4],
        orderable: false,
      },
    ],
    ajax: {
      url: "/core/pendaftar.php?method=get",
      dataType: "json",
      type: "POST",
    },
    columns: [
      {
        data: "no",
      },
      {
        data: "nama",
      },
      {
        data: "email",
      },
      {
        data: "username",
      },
      {
        data: "aksi",
      },
    ],
  });
}

function createOrUpdate() {
  const id = $("#id").val();
  const nama_depan = $("#nama_depan").val();
  const nama_belakang = $("#nama_belakang").val();
  const email = $("#email").val();
  const username = $("#username").val();
  const password = $("#password").val();
  const type = $("#type").val();
  $.post(
    `core/pendaftar.php?method=${type}`,
    {
      id: id,
      nama_depan: nama_depan,
      nama_belakang: nama_belakang,
      email: email,
      username: username,
      password: password,
    },
    function () {
      $("#modal").modal("hide");
      $("#dataregister").DataTable().ajax.reload();
    }
  );
}

function edit(data) {
  const jsonData = JSON.parse(atob(data));
  $("#id").val(jsonData.id);
  $("#nama_depan").val(jsonData.nama_depan);
  $("#nama_belakang").val(jsonData.nama_belakang);
  $("#email").val(jsonData.email);
  $("#username").val(jsonData.username);
  $("#password").val(jsonData.password);
  $("#type").val("update");
  $("#modal").modal("show");
}

function deleted(data) {
  if (confirm("Yakin hapus data ini?")) {
    $.post(
      `core/pendaftar.php?method=delete`,
      {
        id: data,
      },
      function () {
        $("#dataregister").DataTable().ajax.reload();
      }
    );
  } else {
    console.log("Nope.");
  }
}
