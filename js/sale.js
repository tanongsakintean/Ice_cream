var id;
$(document).ready(function () {
  $("#datatable").DataTable({
    searching: false,
  });
});

function edit(id) {
  $.ajax({
    type: "POST",
    url: `action/user_db.php?ac=edit&mem_id=${id}`,
    data: id,
    dataType: "json",
    success: function (data) {
      $("#edit_firstname").val(data[2]);
      $("#edit_lastname").val(data[3]);
      $("#edit_phone").val(data[4]);
      $("#edit_username").val(data[1]);
      $("#edit_password1").val(data[7]);
      $("#edit_password2").val(data[7]);
      if (data[6] === "1") $("#edit_gender1").prop("checked", true);
      else if (data[6] === "2") $("#edit_gender2").prop("checked", true);

      if (data[5] == "1") $("#edit_title1").prop("checked", true);
      else if (data[5] == "2") $("#edit_title2").prop("checked", true);
      else if (data[5] == "3") $("#edit_title3").prop("checked", true);
      $("#action").attr(
        "action",
        `action/user_db.php?ac=edit_cus&mem_id=${data[0]}`
      );
      id = data[0];
    },
  });
}

function del(id) {
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
          url: `action/user_db.php?ac=del&mem_id=${id}`,
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
                  window.location.replace("index.php?p=sale");
                });
            }
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}

var ajaxSubmit = function (formEl) {
  if ($("#mem_firstname").val() == "") {
    $("#mem_firstname").focus();
  } else if ($("#mem_lastname").val() == "") {
    $("#mem_lastname").focus();
  } else if ($("#mem_phone").val() == "") {
    $("#mem_phone").focus();
  } else if ($("#mem_username").val() == "") {
    $("#mem_username").focus();
  } else if ($("#password1").val() == "") {
    $("#password1").focus();
  } else if ($("#password2").val() == "") {
    $("#password2").focus();
  } else if ($("#password1").val() != $("#password2").val()) {
    swal.fire({
      title: "รหัสไม่ตรงกัน",
      icon: "error",
      showCancelButton: false,
      showConfirmButton: false,
      timer: 1000,
    });
    $("#password2").focus();
  } else {
    var url = $(formEl).attr("action");
    var data = $(formEl).serialize();

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      datatype: "html",
      success: function (data) {
        console.log(data);
        if (data == 0) {
          swal.fire({
            title: "อีเมลนี้มีในระบบแล้ว!",
            icon: "error",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1500,
          });
        } else if (data == 1) {
          swal
            .fire({
              title: "เพิ่มข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=sale");
            });
        }
      },
    });
  }
  return false;
};

var ajaxEdit = function (formEl) {
  if ($("#edit_firstname").val() == "") {
    $("#edit_firstname").focus();
  } else if ($("#edit_lastname").val() == "") {
    $("#edit_lastname").focus();
  } else if ($("#edit_phone").val() == "") {
    $("#edit_phone").focus();
  } else if ($("#edit_username").val() == "") {
    $("#edit_username").focus();
  } else if ($("#edit_password1").val() == "") {
    $("#edit_password1").focus();
  } else if ($("#edit_password2").val() == "") {
    $("#edit_password2").focus();
  } else if ($("#edit_password1").val() != $("#edit_password2").val()) {
    swal.fire({
      title: "รหัสไม่ตรงกัน",
      icon: "error",
      showCancelButton: false,
      showConfirmButton: false,
      timer: 1000,
    });
    $("#edit_password2").focus();
  } else {
    var url = $(formEl).attr("action");
    var data = $(formEl).serialize();

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      datatype: "html",
      success: function (data) {
        console.log(data);
        if (data == 0) {
          swal.fire({
            title: "อีเมลนี้มีในระบบแล้ว!",
            icon: "error",
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1500,
          });
        } else if (data == 1) {
          swal
            .fire({
              title: "แก้ไขข้อมูลสำเร็จ!",
              icon: "success",
              showCancelButton: false,
              showConfirmButton: false,
              timer: 1300,
            })
            .then(() => {
              window.location.replace("index.php?p=sale");
            });
        }
      },
    });
  }
  return false;
};
