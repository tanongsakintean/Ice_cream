var status = "add";
var data_id;

$(document).ready(function () {
  $("#pro_img").change(() => {
    var file = $("#pro_img")[0].files[0].name;
    $("#show_file").text(file);
  });

  $("#edit_pro_img").change(() => {
    var file = $("#edit_pro_img")[0].files[0].name;
    $("#edit_show_file").text(file);
  });

  $("#datatable").DataTable({
    searching: false,
    paging: false,
    ordering: false,
  });

  $("#set_data").change(function () {
    $("#val").val($(this).find(":selected").text());
    console.log($("#val").val());
  });
});

var ajax_cate = (formEl) => {
  if ($("#cate_name").val() == "") {
    $("#cate_name").focus();
  } else {
    $.ajax({
      type: "POST",
      url: `action/product_db.php?ac=add_cate&type=${status}&id=${data_id}`,
      data: $(formEl).serialize(),
      dataType: "html",
      success: function (data) {
        if (data == 1) {
          swal
            .fire({
              title: "เพิ่มข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=product");
            });
        } else if (data == 0) {
          swal.fire({
            title: "ข้อมูลซ้ำ!",
            icon: "error",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1300,
          });
        } else if (data == 2) {
          swal
            .fire({
              title: "แก้ไขข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=product");
            });
        }
      },
    });
  }
  return false;
};

var ajax_unit = (formEl) => {
  if ($("#unit_name").val() == "") {
    $("#unit_name").focus();
  } else {
    $.ajax({
      type: "POST",
      url: `action/product_db.php?ac=add_unit&type=${status}&id=${data_id}`,
      data: $(formEl).serialize(),
      dataType: "html",
      success: function (data) {
        if (data == 1) {
          swal
            .fire({
              title: "เพิ่มข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=product");
            });
        } else if (data == 0) {
          swal.fire({
            title: "ข้อมูลซ้ำ!",
            icon: "error",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1300,
          });
        } else if (data == 2) {
          swal
            .fire({
              title: "แก้ไขข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=product");
            });
        }
      },
    });
  }
  return false;
};

var ajax_bank = (formEl) => {
  if ($("#bank_name").val() == "") {
    $("#bank_name").focus();
  } else if ($("#bank_username").val() == "") {
    $("#bank_username").focus();
  } else if ($("#bank_number").val() == "") {
    $("#bank_number").focus();
  } else {
    $.ajax({
      type: "POST",
      url: `action/product_db.php?ac=add_bank&type=${status}&id=${data_id}`,
      data: $(formEl).serialize(),
      dataType: "html",
      success: function (data) {
        if (data == 1) {
          swal
            .fire({
              title: "เพิ่มข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=product");
            });
        } else if (data == 0) {
          swal.fire({
            title: "ข้อมูลซ้ำ!",
            icon: "error",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1300,
          });
        } else if (data == 2) {
          swal
            .fire({
              title: "แก้ไขข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=product");
            });
        }
      },
    });
  }
  return false;
};

function select_product(id) {
  $("#pro_id").val(id);
  $.ajax({
    type: "POST",
    url: `action/product_db.php?ac=select_pro&pro_id=${id}`,
    data: id,
    dataType: "json",
    success: function (data) {
      $("#edit_pro_name").val(data.pro_name);
      $("#edit_pro_code").val(data.pro_code);
      $("#edit_pro_price").val(data.pro_price);
      $("#edit_pro_unit").val(data.pro_unit_id);
      $("#edit_pro_cate").val(data.pro_cate_id);
      $("#edit_pro_description1").val(data.pro_description1);
      $("#edit_pro_description2").val(data.pro_description2);
      $("#edit_show_file").text(data.pro_img);
    },
  });
  return false;
}

function del_product(id) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-gray-500 border-none text-white rounded-md",
      confirmButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-red-500 border-none text-white rounded-md",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "แน่ใจหรือไม่?",
      text: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่",
      cancelButtonText: "ไม่",
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: `action/product_db.php?ac=del_pro&pro_id=${id}`,
          data: id,
          datatype: "html",
          success: function (data) {
            if (data == 1) {
              swal
                .fire({
                  title: "ลบข้อมูลสำเร็จ!",
                  icon: "success",
                  showCancelButton: false,
                  showConfirmButton: false,
                  timer: 1300,
                })
                .then(() => {
                  window.location.replace("index.php?p=product");
                });
            }
          },
        });
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}

function del_category(id) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-gray-500 border-none text-white rounded-md",
      confirmButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-red-500 border-none text-white rounded-md",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: "แน่ใจหรือไม่?",
      text: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่",
      cancelButtonText: "ไม่",
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: `action/product_db.php?ac=del_cate&cate_id=${id}`,
          data: id,
          datatype: "html",
          success: function (data) {
            if (data == 1) {
              swal
                .fire({
                  title: "ลบข้อมูลสำเร็จ!",
                  icon: "success",
                  showCancelButton: false,
                  showConfirmButton: false,
                  timer: 1300,
                })
                .then(() => {
                  window.location.replace("index.php?p=product");
                });
            }
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}

function edit_category(id) {
  data_id = id;
  status = "update";
  $.ajax({
    type: "POST",
    url: `action/product_db.php?ac=edit_cate&cate_id=${id}`,
    data: id,
    dataType: "html",
    success: function (data) {
      $("#cate_name").val(data);
    },
  });
  return false;
}

function del_unit(id) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-gray-500 border-none text-white rounded-md",
      confirmButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-red-500 border-none text-white rounded-md",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "แน่ใจหรือไม่?",
      text: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่",
      cancelButtonText: "ไม่",
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: `action/product_db.php?ac=del_unit&unit_id=${id}`,
          data: id,
          datatype: "html",
          success: function (data) {
            if (data == 1) {
              swal
                .fire({
                  title: "ลบข้อมูลสำเร็จ!",
                  icon: "success",
                  showCancelButton: false,
                  showConfirmButton: false,
                  timer: 1300,
                })
                .then(() => {
                  window.location.replace("index.php?p=product");
                });
            }
          },
        });
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}

function edit_unit(id) {
  data_id = id;
  status = "update";
  $.ajax({
    type: "POST",
    url: `action/product_db.php?ac=edit_unit&unit_id=${id}`,
    data: id,
    dataType: "html",
    success: function (data) {
      $("#unit_name").val(data);
    },
  });
  return false;
}

function edit_bank(id) {
  data_id = id;
  status = "update";
  $.ajax({
    type: "POST",
    url: `action/product_db.php?ac=edit_bank&bank_id=${id}`,
    data: id,
    dataType: "html",
    success: function (data) {
      $("#bank_name").val(JSON.parse(data)[0][1]);
      $("#bank_username").val(JSON.parse(data)[0][2]);
      $("#bank_number").val(JSON.parse(data)[0][3]);
    },
  });
  return false;
}

function del_bank(id) {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      cancelButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-gray-500 border-none text-white rounded-md",
      confirmButton:
        "text-lg w-24 mx-2 py-2 px-3 bg-red-500 border-none text-white rounded-md",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "แน่ใจหรือไม่?",
      text: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่",
      cancelButtonText: "ไม่",
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: `action/product_db.php?ac=del_bank&bank_id=${id}`,
          data: id,
          datatype: "html",
          success: function (data) {
            if (data == 1) {
              swal
                .fire({
                  title: "ลบข้อมูลสำเร็จ!",
                  icon: "success",
                  showCancelButton: false,
                  showConfirmButton: false,
                  timer: 1300,
                })
                .then(() => {
                  window.location.replace("index.php?p=product");
                });
            }
          },
        });
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}
