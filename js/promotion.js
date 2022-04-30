$("#input_val").change(() => {
  console.log(2);
  var file = $("#input_val")[0].files[0].name;
  $("#show_fie").text(file);
});

function del_img(id) {
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
          url: `action/product_db.php?ac=del_pm&pm_id=${id}`,
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
                  window.location.replace("index.php?p=promotion");
                });
            }
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}
