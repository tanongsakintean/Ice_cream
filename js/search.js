$(document).on("keydown", function (e) {
  if (e.which == 13) {
    e.preventDefault();
    if ($("#search").val() == "") {
      $("#search").focus();
    } else {
      $.ajax({
        type: "POST",
        url: $("#formEl").attr("action"),
        data: {
          keyword: $("#search").val(),
        },
        success: function (data) {
          if (JSON.parse(data).length > 0) {
            $("#title").text($("#search").val());
          } else {
            $("#title").text("ไม่พบสินค้า");
          }
          for (let i = 0; i < JSON.parse(data).length; i++) {
            ///ทำคลิ้กแล้วส่งเข้าออเดอร์
            $("#boxSearch").append(`
              <div class="item w-96 ">
                  <div class=" flex justify-center p-8 w-full">
                      <div class="bg-white rounded-lg shadow-md">
                          <div class="px-16 pt-4 flex justify-center items-start">
                              <img src="images/products/${
                                JSON.parse(data)[i][8]
                              }" alt="">
                          </div>
                          <div>
                              <h1 class="text-md text-red-600 py-2 text-center"> ${
                                JSON.parse(data)[i][1]
                              } </h1>
                              <div class="py-4">
                                  <p class="text-center text-gray-500 ${
                                    JSON.parse(data)[i][5] == "" ? "mt-4" : ""
                                  } ">${JSON.parse(data)[i][5]}</p>
                                  <p class="text-center text-gray-500 ${
                                    JSON.parse(data)[i][6] == "" ? "mt-4" : ""
                                  }">${JSON.parse(data)[i][6]}</p>
                              </div>
                              <p class="text-center text-gray-500">1 ${
                                JSON.parse(data)[i][4]
                              } | ${JSON.parse(data)[i][3]} บาท</p>
                              <div class="flex justify-center px-3 py-4">
                                  <button onclick="add_order(${
                                    JSON.parse(data)[i][0]
                                  })" class="text-md py-2 text-white rounded-md w-full px-3 bg-red-500 hover:bg-red-600">สั่งซื้อ</button>
                              </div>
                          </div>
                      </div>
                  </div>
          </div>`);
          }
        },
      });
    }
  }
});

function add_order(pro_id) {
  $.ajax({
    type: "POST",
    url: "action/order_db.php?ac=i_order",
    data: {
      order: pro_id,
    },
    dataType: "html",
    success: function (data) {
      $("#cart").text(parseInt(data));
    },
  });
}
